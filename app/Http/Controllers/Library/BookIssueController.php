<?php

namespace App\Http\Controllers\Library;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\BookIssue;
use App\Models\Branch;
use App\Models\Classes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookIssueController extends Controller
{
    private function branchId(): ?int
    {
        return Auth::user()?->branch_id ?? Branch::query()->value('id');
    }

    private function finePerDay(): float
    {
        return (float) (DB::table('settings')->value('late_fine_per_day') ?? 50);
    }

    public function index(Request $request)
    {
        $branchId = $this->branchId();
        $today    = now()->format('Y-m-d');

        $query = BookIssue::where('branch_id', $branchId)
            ->with(['book', 'user']);

        if ($request->filled('member')) {
            $query->whereHas('user', fn ($q) =>
                $q->where('name', 'like', '%' . $request->member . '%'));
        }
        if ($request->filled('from_date')) {
            $query->whereDate('issue_date', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->whereDate('issue_date', '<=', $request->to_date);
        }
        if ($request->filled('status')) {
            if ($request->status === 'overdue') {
                $query->where('status', 'issued')->whereDate('due_date', '<', $today);
            } else {
                $query->where('status', $request->status);
            }
        }

        $issues = $query->orderByDesc('issue_date')->paginate(20)->withQueryString();

        return view('app.library.issues.index', compact('issues'));
    }

    public function create()
    {
        $books   = Book::where('branch_id', $this->branchId())
            ->where('available', '>', 0)->orderBy('title')->get();
        $classes = Classes::orderBy('numeric_value')->get();

        return view('app.library.issues.create', compact('books', 'classes'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'book_id'    => 'required|exists:books,id',
            'user_id'    => 'required|exists:users,id',
            'issue_date' => 'required|date',
            'due_date'   => 'required|date|after_or_equal:issue_date',
            'notes'      => 'nullable|string',
        ]);

        $book = Book::findOrFail($data['book_id']);

        if ($book->available < 1) {
            return back()->withInput()
                ->with('message', 'This book is not available right now.')
                ->with('alert-type', 'error');
        }

        DB::transaction(function () use ($data, $book) {
            BookIssue::create([
                'branch_id'   => $this->branchId(),
                'book_id'     => $book->id,
                'user_id'     => $data['user_id'],
                'issue_date'  => $data['issue_date'],
                'due_date'    => $data['due_date'],
                'status'      => 'issued',
                'fine_amount' => 0,
                'notes'       => $data['notes'] ?? null,
            ]);

            $book->decrement('available');
        });

        return redirect()->route('library.issues.index')
            ->with('message', 'Book issued successfully.')->with('alert-type', 'success');
    }

    public function show(BookIssue $issue)
    {
        $issue->load(['book', 'user']);
        return view('app.library.issues.show', compact('issue'));
    }

    public function returnBook(BookIssue $issue)
    {
        if ($issue->status !== 'issued') {
            return back()->with('message', 'This book is already closed.')
                ->with('alert-type', 'error');
        }

        $today = now();
        $due   = \Carbon\Carbon::parse($issue->due_date);
        $fine  = $today->gt($due) ? $today->diffInDays($due) * $this->finePerDay() : 0;

        DB::transaction(function () use ($issue, $today, $fine) {
            $issue->update([
                'status'      => 'returned',
                'return_date' => $today->format('Y-m-d'),
                'fine_amount' => round($fine, 2),
            ]);

            $issue->book?->increment('available');
        });

        return redirect()->route('library.issues.index')
            ->with('message', 'Book returned successfully.' . ($fine > 0 ? " Fine: PKR " . number_format($fine, 2) : ''))
            ->with('alert-type', 'success');
    }
}
