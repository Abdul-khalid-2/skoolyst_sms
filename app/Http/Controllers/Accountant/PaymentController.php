<?php

namespace App\Http\Controllers\Accountant;

use App\Http\Controllers\Controller;
use App\Models\FeePayment;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PaymentController extends Controller
{
    public function index(Request $request): View
    {
        $branchId = auth()->user()->branch_id;

        $query = FeePayment::when($branchId, fn ($q) => $q->where('branch_id', $branchId))
            ->with(['fee.student', 'fee.structure.category', 'receivedBy']);

        if ($request->filled('student')) {
            $query->whereHas('fee.student', fn ($q) =>
                $q->where('name', 'like', '%'.$request->student.'%')
            );
        }
        if ($request->filled('from_date')) {
            $query->whereDate('payment_date', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->whereDate('payment_date', '<=', $request->to_date);
        }
        if ($request->filled('method')) {
            $query->where('payment_method', $request->method);
        }

        $totalAmount = (clone $query)->sum('amount');
        $payments = $query->orderByDesc('payment_date')->orderByDesc('id')->paginate(20)->withQueryString();

        return view('app.accountant.payments.index', compact('payments', 'totalAmount'));
    }
}
