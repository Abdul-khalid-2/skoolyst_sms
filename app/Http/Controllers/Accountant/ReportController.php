<?php

namespace App\Http\Controllers\Accountant;

use App\Http\Controllers\Controller;
use App\Models\Fee;
use App\Models\FeePayment;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function index(): View
    {
        $branchId = auth()->user()->branch_id;

        $feeBase = Fee::where('status', '!=', 'cancelled')
            ->when($branchId, fn ($q) => $q->where('branch_id', $branchId));

        $totalBilled = (float) (clone $feeBase)->sum(DB::raw('amount - COALESCE(discount, 0)'));
        $totalCollected = (float) FeePayment::when($branchId, fn ($q) => $q->where('branch_id', $branchId))->sum('amount');
        $outstanding = round(max(0, $totalBilled - $totalCollected), 2);
        $collectionRate = $totalBilled > 0 ? round(($totalCollected / $totalBilled) * 100, 1) : 0;

        $byStatus = Fee::when($branchId, fn ($q) => $q->where('branch_id', $branchId))
            ->select('status', DB::raw('COUNT(*) as count'), DB::raw('SUM(amount - COALESCE(discount, 0)) as total'))
            ->groupBy('status')
            ->get();

        $monthlyCollection = collect(range(5, 0, -1))->map(function ($monthsAgo) use ($branchId) {
            $month = Carbon::now()->subMonths($monthsAgo);
            $amount = FeePayment::when($branchId, fn ($q) => $q->where('branch_id', $branchId))
                ->whereYear('payment_date', $month->year)
                ->whereMonth('payment_date', $month->month)
                ->sum('amount');

            return [
                'label'  => $month->format('M Y'),
                'amount' => round((float) $amount, 2),
            ];
        });

        return view('app.accountant.reports.index', compact(
            'totalBilled',
            'totalCollected',
            'outstanding',
            'collectionRate',
            'byStatus',
            'monthlyCollection'
        ));
    }
}
