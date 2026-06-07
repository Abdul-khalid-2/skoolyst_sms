<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Models\Fee;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class FeeController extends Controller
{
    public function index(): View
    {
        $parent = auth()->user();
        $children = $parent->children()
            ->with(['studentProfile.class', 'studentProfile.section'])
            ->get();

        $childIds = $children->pluck('id');

        $fees = Fee::whereIn('student_id', $childIds)
            ->with(['student', 'structure.category', 'structure.schoolClass', 'payments'])
            ->orderBy('due_date', 'desc')
            ->get()
            ->map(fn (Fee $fee) => $this->decorate($fee));

        $active = $fees->where('status', '!=', 'cancelled');

        $summary = [
            'total_billed'      => round($active->sum('net_payable'), 2),
            'total_paid'        => round($active->sum('paid'), 2),
            'total_outstanding' => round($active->sum('balance'), 2),
            'overdue_count'     => $active->where('is_overdue', true)->count(),
        ];

        return view('app.parent.fees.index', compact('parent', 'children', 'fees', 'summary'));
    }

    private function decorate(Fee $fee): Fee
    {
        $netPayable = (float) $fee->amount - (float) $fee->discount;
        $paid = (float) $fee->payments->sum('amount');
        $balance = round($netPayable - $paid, 2);

        $fee->net_payable = round($netPayable, 2);
        $fee->paid = round($paid, 2);
        $fee->balance = $balance;
        $fee->is_overdue = $balance > 0
            && $fee->status !== 'cancelled'
            && $fee->due_date
            && Carbon::parse($fee->due_date)->isPast();

        return $fee;
    }
}
