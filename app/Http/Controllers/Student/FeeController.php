<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Fee;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class FeeController extends Controller
{
    /**
     * Display the authenticated student's fee invoices and a summary.
     */
    public function index(): View
    {
        $student = auth()->user()->load(['studentProfile.class', 'studentProfile.section']);

        $fees = Fee::where('student_id', $student->id)
            ->with(['structure.category', 'structure.schoolClass', 'payments'])
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

        return view('app.student.fees.index', compact('student', 'fees', 'summary'));
    }

    /**
     * Display a single invoice with its payment history.
     */
    public function show(Fee $fee): View
    {
        abort_unless($fee->student_id === auth()->id(), 404);

        $fee->load([
            'structure.category',
            'structure.schoolClass',
            'payments.receivedBy',
        ]);

        $fee = $this->decorate($fee);
        $student = auth()->user()->load(['studentProfile.class', 'studentProfile.section']);

        return view('app.student.fees.show', compact('student', 'fee'));
    }

    /**
     * Attach computed payable/paid/balance/overdue attributes to a fee record.
     */
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
