<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\BookIssue;
use App\Models\Branch;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class LibrarySeeder extends Seeder
{
    public function run(): void
    {
        if (Book::count() > 0) {
            $this->command->info('Library data already seeded. Skipping.');
            return;
        }

        $branchId    = Branch::query()->value('id') ?? 1;
        $finePerDay  = (float) (\DB::table('settings')->value('late_fine_per_day') ?? 50);

        // ── 1. Books ──────────────────────────────────────────────────────────────
        $bookDefs = [
            ['Wings of Fire', 'A.P.J. Abdul Kalam', 'Science', 'Universities Press', 'Biography'],
            ['A Brief History of Time', 'Stephen Hawking', 'Science', 'Bantam Books', 'Reference'],
            ['The Theory of Everything', 'Stephen Hawking', 'Science', 'Jaico', 'Reference'],
            ['Fundamentals of Physics', 'Halliday & Resnick', 'Science', 'Wiley', 'Reference'],
            ['Concepts of Chemistry', 'P. Bahadur', 'Science', 'G.R. Bathla', 'Reference'],
            ['Higher Algebra', 'Hall & Knight', 'Mathematics', 'Arihant', 'Reference'],
            ['Calculus', 'Thomas & Finney', 'Mathematics', 'Pearson', 'Reference'],
            ['Mathematics for Class 10', 'R.D. Sharma', 'Mathematics', 'Dhanpat Rai', 'Reference'],
            ['Trigonometry', 'S.L. Loney', 'Mathematics', 'Arihant', 'Reference'],
            ['Wren & Martin English Grammar', 'Wren & Martin', 'English', 'S. Chand', 'Reference'],
            ['Oxford English Dictionary', 'Oxford', 'English', 'Oxford Press', 'Reference'],
            ['The Adventures of Tom Sawyer', 'Mark Twain', 'English', 'Penguin', 'Fiction'],
            ['Pride and Prejudice', 'Jane Austen', 'English', 'Penguin Classics', 'Fiction'],
            ['To Kill a Mockingbird', 'Harper Lee', 'English', 'Grand Central', 'Fiction'],
            ['Harry Potter and the Sorcerer\'s Stone', 'J.K. Rowling', 'English', 'Bloomsbury', 'Fiction'],
            ['Aab-e-Hayat', 'Muhammad Husain Azad', 'Urdu', 'Sang-e-Meel', 'Non-Fiction'],
            ['Bang-e-Dra', 'Allama Iqbal', 'Urdu', 'Iqbal Academy', 'Non-Fiction'],
            ['Indian History', 'Bipan Chandra', 'History', 'Orient BlackSwan', 'Reference'],
            ['World Geography', 'Majid Husain', 'Geography', 'McGraw Hill', 'Reference'],
            ['Introduction to Computers', 'Peter Norton', 'Computer', 'McGraw Hill', 'Reference'],
            ['Let Us C', 'Yashavant Kanetkar', 'Computer', 'BPB', 'Reference'],
            ['Python Crash Course', 'Eric Matthes', 'Computer', 'No Starch Press', 'Reference'],
            ['Islamic Studies', 'Hafiz Salahuddin', 'Islamic Studies', 'Darussalam', 'Reference'],
            ['The Story of Art', 'E.H. Gombrich', 'Arts', 'Phaidon', 'Reference'],
            ['Encyclopedia of Sports', 'DK Publishing', 'Sports', 'DK', 'Reference'],
        ];

        $shelves = ['A-01','A-02','A-03','B-01','B-02','B-03','C-01','C-02','C-03','D-01','D-02'];
        $books   = [];

        foreach ($bookDefs as $i => [$title, $author, $category, $publisher, $type]) {
            $quantity  = rand(3, 12);
            $available = $quantity; // adjusted below as issues are created

            $books[] = Book::create([
                'branch_id'    => $branchId,
                'title'        => $title,
                'author'       => $author,
                'isbn'         => '978-' . rand(1000000000, 9999999999),
                'publisher'    => $publisher,
                'edition'      => rand(1, 5) . ($i % 2 ? 'st' : 'rd') . ' Edition',
                'category'     => $category,
                'price'        => rand(150, 2500),
                'quantity'     => $quantity,
                'available'    => $available,
                'shelf_number' => $shelves[array_rand($shelves)],
            ]);
        }

        $this->command->info('✓ ' . count($books) . ' books created.');

        // ── 2. Members (students + teachers) ──────────────────────────────────────
        $members = User::role('student')->where('branch_id', $branchId)->inRandomOrder()->take(25)->get()
            ->merge(User::role('teacher')->where('branch_id', $branchId)->inRandomOrder()->take(5)->get());

        if ($members->isEmpty()) {
            $this->command->warn('No members found — skipping book issues.');
            return;
        }

        // ── 3. Book Issues ────────────────────────────────────────────────────────
        $issueCount = 0;
        $today      = Carbon::today();

        // status distribution: returned (history), issued (active), overdue, lost
        foreach ($members as $member) {
            $numIssues = rand(1, 3);

            for ($n = 0; $n < $numIssues; $n++) {
                /** @var Book $book */
                $book = $books[array_rand($books)];

                $scenario = ['returned', 'returned', 'issued', 'issued', 'overdue', 'lost'][array_rand([0,1,2,3,4,5])];

                $issueDate = (clone $today)->subDays(rand(5, 90));
                $dueDate   = (clone $issueDate)->addDays(14);

                $returnDate = null;
                $fine       = 0;
                $status     = 'issued';

                switch ($scenario) {
                    case 'returned':
                        // returned on time or slightly late
                        $returnDate = (clone $dueDate)->subDays(rand(-3, 10));
                        if ($returnDate->gt($dueDate)) {
                            $fine = $returnDate->diffInDays($dueDate) * $finePerDay;
                        }
                        if ($returnDate->gt($today)) $returnDate = clone $today;
                        $status = 'returned';
                        break;

                    case 'issued':
                        // active, not yet due
                        $issueDate = (clone $today)->subDays(rand(1, 10));
                        $dueDate   = (clone $issueDate)->addDays(14);
                        $status    = 'issued';
                        $book->decrement('available');
                        break;

                    case 'overdue':
                        // active, past due date — fine accrues
                        $issueDate = (clone $today)->subDays(rand(20, 45));
                        $dueDate   = (clone $issueDate)->addDays(14);
                        $fine      = $dueDate->diffInDays($today) * $finePerDay;
                        $status    = 'issued'; // overdue is derived from due_date < today
                        $book->decrement('available');
                        break;

                    case 'lost':
                        $status = 'lost';
                        $fine   = $book->price; // charge book price
                        $book->decrement('available');
                        break;
                }

                BookIssue::create([
                    'branch_id'   => $branchId,
                    'book_id'     => $book->id,
                    'user_id'     => $member->id,
                    'issue_date'  => $issueDate->format('Y-m-d'),
                    'due_date'    => $dueDate->format('Y-m-d'),
                    'return_date' => $returnDate?->format('Y-m-d'),
                    'status'      => $status,
                    'fine_amount' => round($fine, 2),
                    'notes'       => null,
                ]);

                $issueCount++;
            }
        }

        // Guard: never let available go below zero
        foreach ($books as $book) {
            if ($book->available < 0) {
                $book->update(['available' => 0]);
            }
        }

        $this->command->info("✓ {$issueCount} book issues created.");
    }
}
