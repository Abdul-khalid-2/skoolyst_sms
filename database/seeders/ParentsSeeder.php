<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\ParentProfile;
use App\Models\StudentParent;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ParentsSeeder extends Seeder
{
    public function run(): void
    {
        if (User::where('role', 'parent')->count() > 0) {
            $this->command->info('Parent data already seeded. Skipping.');
            return;
        }

        // ─── Resolve Branch ──────────────────────────────────────────────────────
        $branch = Branch::first();
        if (! $branch) {
            $this->command->warn('No branch found. Run TestDataSeeder first.');
            return;
        }
        $branchId = $branch->id;

        // ─── Fetch Students (created by TestDataSeeder) ───────────────────────────
        $students = User::where('role', 'student')
            ->where('branch_id', $branchId)
            ->orderBy('id')
            ->get();

        if ($students->isEmpty()) {
            $this->command->warn('No students found. Run TestDataSeeder first.');
            return;
        }

        // ─── Data Pools ───────────────────────────────────────────────────────────
        $surnames = [
            'Khan', 'Ahmed', 'Malik', 'Sheikh', 'Raza', 'Tariq', 'Hussain', 'Iqbal',
            'Butt', 'Chaudhry', 'Qureshi', 'Siddiqui', 'Farooq', 'Aslam', 'Nawaz',
            'Mehmood', 'Saleem', 'Hashmi', 'Abbasi', 'Rashid', 'Akram', 'Javed',
            'Mughal', 'Zaman',
        ];
        $fatherFirstNames = [
            'Imran', 'Asif', 'Naveed', 'Kashif', 'Rashid', 'Adnan', 'Waqas', 'Saqib',
            'Faisal', 'Junaid', 'Shahid', 'Tanveer', 'Zahid', 'Arshad', 'Khalid',
            'Yasir', 'Nadeem', 'Aamir', 'Sajid', 'Rizwan', 'Hassan', 'Salman',
            'Owais', 'Danish',
        ];
        $motherFirstNames = [
            'Saima', 'Nazia', 'Farah', 'Rabia', 'Shazia', 'Bushra', 'Naila', 'Asma',
            'Kiran', 'Sadia', 'Uzma', 'Lubna', 'Samina', 'Tahira', 'Yasmin', 'Rukhsana',
            'Naheed', 'Sumaira', 'Kausar', 'Shabana', 'Nasreen', 'Razia', 'Fauzia', 'Humaira',
        ];
        $occupations = [
            'Business Owner', 'Doctor', 'Engineer', 'Government Officer', 'Teacher',
            'Banker', 'Shopkeeper', 'Accountant', 'Lawyer', 'Pharmacist',
        ];
        $employers = [
            'Self Employed', 'City Hospital', 'National Bank', 'Govt. Department',
            'Private Firm', 'NESPAK', 'PTCL', 'Local Business',
        ];
        $incomeRanges    = ['25000-50000', '50000-100000', '100000-200000', '200000+'];
        $educationLevels = ['Matric', 'Intermediate', 'Bachelors', 'Masters', 'PhD'];

        // ─── Group Students into Families (siblings share parents) ─────────────────
        // Pairs of consecutive students form a family of up to 2 children.
        $families      = $students->chunk(2);
        $familyCounter = 0;
        $parentCount   = 0;

        foreach ($families as $children) {
            $familyCounter++;
            $surname = $surnames[($familyCounter - 1) % count($surnames)];

            // ── Father (primary contact) ──────────────────────────────────────────
            $fatherFirst = $fatherFirstNames[($familyCounter - 1) % count($fatherFirstNames)];
            $father = User::firstOrCreate(
                ['email' => "parent.father{$familyCounter}@skoolyst.com"],
                [
                    'name'      => "{$fatherFirst} {$surname}",
                    'password'  => Hash::make('password'),
                    'role'      => 'parent',
                    'status'    => 'active',
                    'branch_id' => $branchId,
                    'gender'    => 'male',
                    'phone'     => '0301-' . str_pad($familyCounter, 7, '0', STR_PAD_LEFT),
                    'address'   => "House #{$familyCounter}, Street {$familyCounter}, Hyderabad",
                ]
            );
            if (! $father->hasRole('parent')) {
                $father->assignRole('parent');
            }

            ParentProfile::firstOrCreate(
                ['parent_id' => $father->id],
                [
                    'branch_id'         => $branchId,
                    'occupation'        => $occupations[($familyCounter - 1) % count($occupations)],
                    'employer'          => $employers[($familyCounter - 1) % count($employers)],
                    'income_range'      => $incomeRanges[($familyCounter - 1) % count($incomeRanges)],
                    'education_level'   => $educationLevels[($familyCounter - 1) % count($educationLevels)],
                    'relation_type'     => 'father',
                    'is_primary'        => true,
                    'emergency_contact' => '0301-' . str_pad($familyCounter, 7, '0', STR_PAD_LEFT),
                ]
            );
            $parentCount++;

            // ── Mother ────────────────────────────────────────────────────────────
            $motherFirst = $motherFirstNames[($familyCounter - 1) % count($motherFirstNames)];
            $mother = User::firstOrCreate(
                ['email' => "parent.mother{$familyCounter}@skoolyst.com"],
                [
                    'name'      => "{$motherFirst} {$surname}",
                    'password'  => Hash::make('password'),
                    'role'      => 'parent',
                    'status'    => 'active',
                    'branch_id' => $branchId,
                    'gender'    => 'female',
                    'phone'     => '0302-' . str_pad($familyCounter, 7, '0', STR_PAD_LEFT),
                    'address'   => "House #{$familyCounter}, Street {$familyCounter}, Hyderabad",
                ]
            );
            if (! $mother->hasRole('parent')) {
                $mother->assignRole('parent');
            }

            ParentProfile::firstOrCreate(
                ['parent_id' => $mother->id],
                [
                    'branch_id'         => $branchId,
                    'occupation'        => 'Housewife',
                    'employer'          => null,
                    'income_range'      => $incomeRanges[0],
                    'education_level'   => $educationLevels[($familyCounter) % count($educationLevels)],
                    'relation_type'     => 'mother',
                    'is_primary'        => false,
                    'emergency_contact' => '0302-' . str_pad($familyCounter, 7, '0', STR_PAD_LEFT),
                ]
            );
            $parentCount++;

            // ── Link Both Parents to the Family's Children ────────────────────────
            foreach ($children as $child) {
                StudentParent::firstOrCreate(
                    ['student_id' => $child->id, 'parent_id' => $father->id],
                    ['relationship' => 'father', 'is_primary' => true]
                );

                StudentParent::firstOrCreate(
                    ['student_id' => $child->id, 'parent_id' => $mother->id],
                    ['relationship' => 'mother', 'is_primary' => false]
                );
            }
        }

        $this->command->info("✓ {$parentCount} parents created across {$familyCounter} families.");
        $this->command->info("✓ Student-parent relationships linked.");
        $this->command->info("- Login: parent emails use password 'password'");
    }
}
