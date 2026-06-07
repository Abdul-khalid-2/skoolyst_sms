<?php

namespace App\Http\Controllers\Accountant;

use App\Http\Controllers\Controller;
use App\Models\Fee;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class FeeController extends Controller
{
    public function index(Request $request): View
    {
        $branchId = auth()->user()->branch_id;

        $query = Fee::when($branchId, fn ($q) => $q->where('branch_id', $branchId))
            ->with(['student', 'structure.category', 'structure.schoolClass', 'payments']);

        if ($request->filled('student')) {
            $query->whereHas('student', fn ($q) =>
                $q->where('name', 'like', '%'.$request->student.'%')
            );
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('from_date')) {
            $query->whereDate('due_date', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->whereDate('due_date', '<=', $request->to_date);
        }

        $fees = $query->orderByDesc('due_date')->paginate(20)->withQueryString();

        $fees->getCollection()->transform(fn (Fee $fee) => $this->decorate($fee));

        return view('app.accountant.fees.index', compact('fees'));
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
