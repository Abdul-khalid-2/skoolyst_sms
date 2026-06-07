<?php

namespace App\Http\Controllers\Accountant;

use App\Http\Controllers\Controller;
use App\Models\Fee;
use App\Models\FeePayment;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $branchId = auth()->user()->branch_id;

        $feeQuery = Fee::where('status', '!=', 'cancelled')
            ->when($branchId, fn ($q) => $q->where('branch_id', $branchId));

        $totalBilled = (float) $feeQuery->sum(DB::raw('amount - COALESCE(discount, 0)'));

        $collectedFees = (float) FeePayment::when(
            $branchId,
            fn ($q) => $q->where('branch_id', $branchId)
        )->sum('amount');

        $outstandingFees = round(max(0, $totalBilled - $collectedFees), 2);
        $feeCollectionRate = $totalBilled > 0
            ? round(($collectedFees / $totalBilled) * 100, 1)
            : 0;

        $recentPayments = FeePayment::when($branchId, fn ($q) => $q->where('branch_id', $branchId))
            ->with(['fee.student', 'fee.structure.category', 'receivedBy'])
            ->orderByDesc('payment_date')
            ->orderByDesc('id')
            ->take(10)
            ->get();

        $pendingCount = Fee::when($branchId, fn ($q) => $q->where('branch_id', $branchId))
            ->whereIn('status', ['pending', 'partial'])
            ->count();

        $overdueCount = Fee::when($branchId, fn ($q) => $q->where('branch_id', $branchId))
            ->whereIn('status', ['pending', 'partial'])
            ->whereDate('due_date', '<', Carbon::today())
            ->count();

        return view('app.accountant.dashboard', compact(
            'totalBilled',
            'collectedFees',
            'outstandingFees',
            'feeCollectionRate',
            'recentPayments',
            'pendingCount',
            'overdueCount'
        ));
    }
}
