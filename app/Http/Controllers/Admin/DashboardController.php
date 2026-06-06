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

        // ── People ───────────────────────────────────────────────────
        $numberOfTeachers = User::role('teacher')->count();
        $numberOfStudent  = User::role('student')->count();
        $numberOfParents  = User::role('parent')->count();

        $section       = Section::sum('capacity');   // total seat capacity
        $totalClasses  = Classes::count();
        $totalSubjects = Subject::count();

        // Student : teacher ratio (e.g. 18 students per teacher).
        $studentTeacherRatio = $numberOfTeachers > 0
            ? round($numberOfStudent / $numberOfTeachers, 1)
            : 0;

        // ── Fees ─────────────────────────────────────────────────────
        $collectedFees = (float) FeePayment::sum('amount');
        $totalBilled   = (float) Fee::where('status', '!=', 'cancelled')
            ->sum(DB::raw('amount - COALESCE(discount, 0)'));
        $outstandingFees = round(max(0, $totalBilled - $collectedFees), 2);

        $feeCollectionRate = $totalBilled > 0
            ? round(($collectedFees / $totalBilled) * 100, 1)
            : 0;

        // ── Salaries ─────────────────────────────────────────────────
        $paidSalaries = (float) SalaryPayment::sum(
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
        ])->select(['payment_date', 'amount'])->get();

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
