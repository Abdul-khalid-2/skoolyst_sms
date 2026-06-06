<?php

namespace App\Http\Controllers\Fees;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Classes;
use App\Models\Fee;
use App\Models\FeePayment;
use App\Models\FeeStructure;
use App\Models\StudentProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class FeePaymentController extends Controller
{
    private function branchId(): ?int
    {
        return Auth::user()?->branch_id;
    }

    public function index(Request $request)
    {
        $branchId = $this->branchId();

        $query = Fee::where('branch_id', $branchId)
            ->with(['student', 'structure.category', 'structure.schoolClass']);

        if ($request->filled('student')) {
            $query->whereHas('student', fn ($q) =>
                $q->where('name', 'like', '%' . $request->student . '%')
            );
        }
        if ($request->filled('from_date')) {
            $query->whereDate('due_date', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->whereDate('due_date', '<=', $request->to_date);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $payments = $query->orderBy('due_date', 'desc')->paginate(20)->withQueryString();

        return view('app.fees.payments.index', compact('payments'));
    }

    public function create()
    {
        $branchId   = $this->branchId();
        $structures = FeeStructure::with(['category', 'schoolClass'])->orderBy('name')->get();
        $classes    = Classes::when($branchId, fn ($q) => $q->where('branch_id', $branchId))->orderBy('numeric_value')->get();
        return view('app.fees.payments.create', compact('structures', 'classes'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'student_id'            => 'required|exists:users,id',
            'structure_id'          => 'required|exists:fee_structures,id',
            'amount'                => 'required|numeric|min:0',
            'discount'              => 'nullable|numeric|min:0',
            'due_date'              => 'required|date',
            'status'                => 'required|in:pending,paid,partial,cancelled',
            'payment_method'        => 'nullable|in:cash,cheque,card,bank_transfer,online',
            'transaction_reference' => 'nullable|string|max:100',
            'notes'                 => 'nullable|string',
        ]);

        $data['branch_id']      = $this->branchId();
        $data['invoice_number'] = 'INV-' . strtoupper(Str::random(8));
        $data['discount']       = $data['discount'] ?? 0;

        if (in_array($data['status'], ['paid', 'partial'])) {
            $data['payment_date'] = now()->format('Y-m-d');
        }

        $fee = Fee::create($data);

        // Record in fee_payments if money was received
        if (in_array($fee->status, ['paid', 'partial'])) {
            $paidAmount = $fee->status === 'partial'
                ? round(($fee->amount - $fee->discount) * 0.5, 2)
                : ($fee->amount - $fee->discount);

            FeePayment::create([
                'branch_id'             => $fee->branch_id,
                'fee_id'                => $fee->id,
                'amount'                => $paidAmount,
                'payment_date'          => $fee->payment_date,
                'payment_method'        => $fee->payment_method,
                'transaction_reference' => $fee->transaction_reference,
                'received_by'           => Auth::id(),
            ]);
        }

        return redirect()->route('fees.payments.index')
            ->with('message', 'Payment recorded successfully. Invoice: ' . $fee->invoice_number)
            ->with('alert-type', 'success');
    }

    public function show(Fee $payment)
    {
        $payment->load(['student.studentProfile.class', 'structure.category', 'structure.schoolClass', 'payments.receivedBy']);
        return view('app.fees.payments.show', compact('payment'));
    }

    public function destroy(Fee $payment)
    {
        $payment->payments()->delete();
        $payment->delete();

        return redirect()->route('fees.payments.index')
            ->with('message', 'Fee record deleted.')
            ->with('alert-type', 'success');
    }

    /** AJAX — get students for a class */
    public function getStudentsByClass(Request $request)
    {
        $request->validate(['class_id' => 'required|exists:classes,id']);

        $students = StudentProfile::with('student')
            ->where('class_id', $request->class_id)
            ->get()
            ->map(fn ($p) => [
                'id'   => $p->student->id,
                'name' => $p->student->name . ' (' . ($p->admission_no ?? 'N/A') . ')',
            ]);

        return response()->json(['students' => $students]);
    }
}
