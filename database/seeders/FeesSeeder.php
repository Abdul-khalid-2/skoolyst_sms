<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Classes;
use App\Models\Fee;
use App\Models\FeeCategory;
use App\Models\FeePayment;
use App\Models\FeeStructure;
use App\Models\StudentProfile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class FeesSeeder extends Seeder
{
    public function run(): void
    {
        if (FeeCategory::count() > 0) {
            $this->command->info('Fees data already seeded. Skipping.');
            return;
        }

        $branch   = Branch::first();
        $branchId = $branch?->id ?? 1;
        $admin    = User::role('admin')->first() ?? User::role('super-admin')->first();

        // ── 1. Fee Categories ────────────────────────────────────────────────────
        $categoryDefs = [
            ['name' => 'Tuition Fee',    'description' => 'Monthly tuition charges'],
            ['name' => 'Transport Fee',  'description' => 'School bus / van charges'],
            ['name' => 'Library Fee',    'description' => 'Annual library membership'],
            ['name' => 'Lab Fee',        'description' => 'Science & computer lab usage'],
            ['name' => 'Sports Fee',     'description' => 'Annual sports activities'],
            ['name' => 'Admission Fee',  'description' => 'One-time admission charge'],
        ];

        $categories = [];
        foreach ($categoryDefs as $def) {
            $categories[$def['name']] = FeeCategory::create([
                'branch_id'   => $branchId,
                'name'        => $def['name'],
                'description' => $def['description'],
            ]);
        }
        $this->command->info('✓ ' . count($categories) . ' fee categories created.');

        // ── 2. Fee Structures (per class) ────────────────────────────────────────
        $classes = Classes::where('branch_id', $branchId)->orderBy('numeric_value')->get();

        // Tuition: amount scales with class level
        $tuitionAmounts = [1=>2000, 2=>2200, 3=>2400, 4=>2600, 5=>2800, 6=>3000, 7=>3200];
        $structures = [];

        foreach ($classes as $class) {
            $level = $class->numeric_value ?? 1;

            // Tuition — monthly, per class
            $structures[] = FeeStructure::create([
                'branch_id'   => $branchId,
                'category_id' => $categories['Tuition Fee']->id,
                'class_id'    => $class->id,
                'name'        => "Tuition Fee — {$class->name}",
                'amount'      => $tuitionAmounts[$level] ?? 2500,
                'frequency'   => 'monthly',
                'due_date'    => now()->startOfMonth()->addDays(9)->format('Y-m-d'),
            ]);

            // Lab fee — yearly, for class 4+
            if ($level >= 4) {
                $structures[] = FeeStructure::create([
                    'branch_id'   => $branchId,
                    'category_id' => $categories['Lab Fee']->id,
                    'class_id'    => $class->id,
                    'name'        => "Lab Fee — {$class->name}",
                    'amount'      => 1500,
                    'frequency'   => 'yearly',
                    'due_date'    => now()->startOfYear()->addMonth()->format('Y-m-d'),
                ]);
            }
        }

        // Transport & Sports — school-wide (no class restriction)
        $structures[] = FeeStructure::create([
            'branch_id'   => $branchId,
            'category_id' => $categories['Transport Fee']->id,
            'class_id'    => null,
            'name'        => 'Transport Fee (Monthly)',
            'amount'      => 1200,
            'frequency'   => 'monthly',
            'due_date'    => now()->startOfMonth()->addDays(9)->format('Y-m-d'),
        ]);

        $structures[] = FeeStructure::create([
            'branch_id'   => $branchId,
            'category_id' => $categories['Sports Fee']->id,
            'class_id'    => null,
            'name'        => 'Sports Fee (Annual)',
            'amount'      => 1000,
            'frequency'   => 'yearly',
            'due_date'    => now()->startOfYear()->addMonth()->format('Y-m-d'),
        ]);

        $structures[] = FeeStructure::create([
            'branch_id'   => $branchId,
            'category_id' => $categories['Library Fee']->id,
            'class_id'    => null,
            'name'        => 'Library Fee (Annual)',
            'amount'      => 500,
            'frequency'   => 'yearly',
            'due_date'    => now()->startOfYear()->addMonth()->format('Y-m-d'),
        ]);

        $structures[] = FeeStructure::create([
            'branch_id'   => $branchId,
            'category_id' => $categories['Admission Fee']->id,
            'class_id'    => null,
            'name'        => 'Admission Fee (One Time)',
            'amount'      => 3000,
            'frequency'   => 'one_time',
            'due_date'    => null,
        ]);

        $this->command->info('✓ ' . count($structures) . ' fee structures created.');

        // ── 3. Fee Records for Students ──────────────────────────────────────────
        $students = StudentProfile::with(['student', 'class'])->get();

        if ($students->isEmpty()) {
            $this->command->warn('No students found — skipping fee records.');
            return;
        }

        $statuses        = ['paid', 'paid', 'paid', 'pending', 'partial'];
        $paymentMethods  = ['cash', 'cash', 'bank_transfer', 'cheque', 'online'];
        $feeCount        = 0;
        $paymentCount    = 0;

        foreach ($students as $profile) {
            $student  = $profile->student;
            $classId  = $profile->class_id;

            // Find the tuition structure for this student's class
            $tuitionStructure = FeeStructure::where('category_id', $categories['Tuition Fee']->id)
                ->where('class_id', $classId)
                ->first();

            if (! $tuitionStructure) continue;

            // Create 2 months of tuition fees per student
            foreach ([-1, 0] as $monthOffset) {
                $dueDate     = now()->addMonths($monthOffset)->startOfMonth()->addDays(9);
                $statusIndex = array_rand($statuses);
                $status      = $statuses[$statusIndex];
                $discount    = ($statusIndex === 4) ? 200 : 0; // small discount for partial
                $amount      = $tuitionStructure->amount;

                $fee = Fee::create([
                    'branch_id'      => $branchId,
                    'student_id'     => $student->id,
                    'structure_id'   => $tuitionStructure->id,
                    'invoice_number' => 'INV-' . strtoupper(Str::random(8)),
                    'amount'         => $amount,
                    'discount'       => $discount,
                    'due_date'       => $dueDate->format('Y-m-d'),
                    'status'         => $status,
                    'payment_date'   => in_array($status, ['paid', 'partial'])
                                            ? $dueDate->subDays(rand(0, 5))->format('Y-m-d')
                                            : null,
                    'payment_method' => in_array($status, ['paid', 'partial'])
                                            ? $paymentMethods[array_rand($paymentMethods)]
                                            : null,
                    'transaction_reference' => in_array($status, ['paid', 'partial'])
                                            ? 'TXN-' . strtoupper(Str::random(6))
                                            : null,
                ]);

                $feeCount++;

                // Create FeePayment record for paid/partial fees
                if (in_array($status, ['paid', 'partial'])) {
                    $paidAmount = $status === 'partial'
                        ? round(($amount - $discount) * 0.5, 2)
                        : ($amount - $discount);

                    FeePayment::create([
                        'branch_id'             => $branchId,
                        'fee_id'                => $fee->id,
                        'amount'                => $paidAmount,
                        'payment_date'          => $fee->payment_date,
                        'payment_method'        => $fee->payment_method,
                        'transaction_reference' => $fee->transaction_reference,
                        'received_by'           => $admin?->id,
                        'notes'                 => null,
                    ]);

                    $paymentCount++;
                }
            }
        }

        $this->command->info("✓ {$feeCount} fee records created.");
        $this->command->info("✓ {$paymentCount} payment records created.");
    }
}
