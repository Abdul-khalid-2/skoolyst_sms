<?php

namespace App\Http\Controllers\Fees;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Fee;
use App\Models\FeeCategory;
use App\Models\FeePayment;
use App\Models\FeeStructure;
use Illuminate\Support\Facades\Auth;

class FeesController extends Controller
{
    private function branchId(): ?int
    {
        return Auth::user()?->branch_id ?? Branch::query()->value('id');
    }

    public function index()
    {
        $branchId = $this->branchId();

        $totalCollected = Fee::where('branch_id', $branchId)
            ->whereIn('status', ['paid', 'partial'])
            ->sum(\DB::raw('amount - discount'));

        $outstanding = Fee::where('branch_id', $branchId)
            ->whereIn('status', ['pending', 'partial'])
            ->sum(\DB::raw('amount - discount'));

        $paidStudentsThisMonth = Fee::where('branch_id', $branchId)
            ->where('status', 'paid')
            ->whereMonth('payment_date', now()->month)
            ->whereYear('payment_date', now()->year)
            ->distinct('student_id')
            ->count('student_id');

        $defaulters = Fee::where('branch_id', $branchId)
            ->where('status', 'pending')
            ->where('due_date', '<', now()->subDays(30)->format('Y-m-d'))
            ->distinct('student_id')
            ->count('student_id');

        $recentPayments = Fee::where('branch_id', $branchId)
            ->with(['student', 'structure.category'])
            ->whereIn('status', ['paid', 'partial'])
            ->orderBy('payment_date', 'desc')
            ->limit(10)
            ->get();

        return view('app.fees.index', compact(
            'totalCollected', 'outstanding', 'paidStudentsThisMonth',
            'defaulters', 'recentPayments'
        ));
    }
}
