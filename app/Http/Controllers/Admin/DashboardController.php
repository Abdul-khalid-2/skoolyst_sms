<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\Fee;
use App\Models\FeePayment;
use App\Models\SalaryPayment;
use App\Models\Section;
use App\Models\Subject;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the role-appropriate dashboard.
     */
    public function index(Request $request): View
    {
        // Students get their own personalised dashboard.
        if (auth()->user()->hasRole('student')) {
            return app(\App\Http\Controllers\Student\DashboardController::class)->index();
        }

        $branchId       = auth()->user()->branch_id;
        $isSuperAdmin   = auth()->user()->hasRole('super-admin');

        // ── People ───────────────────────────────────────────────────
        $numberOfTeachers = User::role('teacher')
            ->when(! $isSuperAdmin && $branchId, fn ($q) => $q->where('branch_id', $branchId))
            ->count();
        $numberOfStudent  = User::role('student')
            ->when(! $isSuperAdmin && $branchId, fn ($q) => $q->where('branch_id', $branchId))
            ->count();
        $numberOfParents  = User::role('parent')
            ->when(! $isSuperAdmin && $branchId, fn ($q) => $q->where('branch_id', $branchId))
            ->count();

        $section       = Section::when(! $isSuperAdmin && $branchId, fn ($q) => $q->where('branch_id', $branchId))
            ->sum('capacity');
        $totalClasses  = Classes::when(! $isSuperAdmin && $branchId, fn ($q) => $q->where('branch_id', $branchId))
            ->count();
        $totalSubjects = Subject::when(! $isSuperAdmin && $branchId, fn ($q) => $q->where('branch_id', $branchId))
            ->count();

        // Student : teacher ratio (e.g. 18 students per teacher).
        $studentTeacherRatio = $numberOfTeachers > 0
            ? round($numberOfStudent / $numberOfTeachers, 1)
            : 0;

        // ── Fees ─────────────────────────────────────────────────────
        // fee_payments and fees link to students; scope via student's branch_id.
        $studentIds = $isSuperAdmin || ! $branchId
            ? null
            : User::role('student')->where('branch_id', $branchId)->pluck('id');

        $feeQuery = Fee::where('status', '!=', 'cancelled')
            ->when($studentIds !== null, fn ($q) => $q->whereIn('student_id', $studentIds));

        $totalBilled = (float) $feeQuery->sum(DB::raw('amount - COALESCE(discount, 0)'));

        $collectedFees = (float) FeePayment::when(
            $studentIds !== null,
            fn ($q) => $q->whereHas('fee', fn ($fq) => $fq->whereIn('student_id', $studentIds))
        )->sum('amount');

        $outstandingFees = round(max(0, $totalBilled - $collectedFees), 2);

        $feeCollectionRate = $totalBilled > 0
            ? round(($collectedFees / $totalBilled) * 100, 1)
            : 0;

        // ── Salaries ─────────────────────────────────────────────────
        $teacherIds = $isSuperAdmin || ! $branchId
            ? null
            : User::role('teacher')->where('branch_id', $branchId)->pluck('id');

        $paidSalaries = (float) SalaryPayment::when(
            $teacherIds !== null,
            fn ($q) => $q->whereIn('teacher_id', $teacherIds)
        )->sum(
            DB::raw('COALESCE(amount, 0) + COALESCE(bonus, 0) - COALESCE(deductions, 0) - COALESCE(tax_amount, 0)')
        );

        // ── Enrollment vs capacity ───────────────────────────────────
        $enrollmentRate = $section > 0
            ? round(($numberOfStudent / $section) * 100, 1)
            : 0;

        // ── School earnings (last 6 months of fee collection) ────────
        $earningsData = collect(range(5, 0, -1))->mapWithKeys(function ($monthsAgo) {
            $month = Carbon::now()->subMonths($monthsAgo);
            return [$month->format('M Y') => 0];
        });

        $payments = FeePayment::whereBetween('payment_date', [
            Carbon::now()->subMonths(5)->startOfMonth(),
            Carbon::now()->endOfMonth(),
        ])->when(
            $studentIds !== null,
            fn ($q) => $q->whereHas('fee', fn ($fq) => $fq->whereIn('student_id', $studentIds))
        )->select(['payment_date', 'amount'])->get();

        $earningsData = $earningsData->map(function ($amount, $month) use ($payments) {
            return $payments->filter(function ($payment) use ($month) {
                return $payment->payment_date && Carbon::parse($payment->payment_date)->format('M Y') === $month;
            })->sum('amount');
        })->toArray();

        return view('app.admin.dashboard', compact(
            'numberOfTeachers',
            'numberOfStudent',
            'numberOfParents',
            'section',
            'totalClasses',
            'totalSubjects',
            'studentTeacherRatio',
            'collectedFees',
            'outstandingFees',
            'feeCollectionRate',
            'paidSalaries',
            'enrollmentRate',
            'earningsData'
        ));
    }
}
