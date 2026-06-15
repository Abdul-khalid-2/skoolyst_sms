<?php

namespace App\Http\Controllers\Accountant;

use App\Http\Controllers\Accountant\Concerns\ScopesAccountantBranch;
use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\FeePayment;
use App\Models\FeeStructure;
use App\Models\StudentProfile;
use App\Services\Accountant\AccountantReportService;
use App\Services\Fees\FeePaymentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class PaymentController extends Controller
{
    use ScopesAccountantBranch;

    public function __construct(
        private FeePaymentService $fees,
        private AccountantReportService $reports,
    ) {}

    public function index(Request $request): View
    {
        $query = $this->reports->paymentsQuery($request, $this->branchId());
        $totalAmount = (clone $query)->sum('amount');
        $payments = $query->paginate(20)->withQueryString();

        return view('app.accountant.payments.index', compact('payments', 'totalAmount'));
    }

    public function exportPdf(Request $request): Response
    {
        return $this->reports->downloadPaymentsPdf($request, $this->branchId());
    }

    public function create(): View
    {
        $branchId = $this->branchId();

        $structures = FeeStructure::with(['category', 'schoolClass'])
            ->when($branchId, fn ($q) => $q->where('branch_id', $branchId))
            ->orderBy('name')
            ->get();

        $classes = Classes::when($branchId, fn ($q) => $q->where('branch_id', $branchId))
            ->orderBy('numeric_value')
            ->get();

        return view('app.accountant.payments.create', compact('structures', 'classes'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'student_id'            => 'required|exists:users,id',
            'structure_id'          => 'required|exists:fee_structures,id',
            'amount'                => 'required|numeric|min:0',
            'discount'              => 'nullable|numeric|min:0',
            'due_date'              => 'required|date',
            'amount_received'       => 'nullable|numeric|min:0',
            'payment_date'          => 'nullable|date|required_with:amount_received',
            'payment_method'        => 'nullable|in:cash,cheque,card,bank_transfer,online|required_with:amount_received',
            'transaction_reference' => 'nullable|string|max:100',
            'notes'                 => 'nullable|string',
        ]);

        $discount = (float) ($data['discount'] ?? 0);
        $net = round((float) $data['amount'] - $discount, 2);
        $received = isset($data['amount_received']) ? round((float) $data['amount_received'], 2) : 0;

        if ($received > $net + 0.009) {
            return back()->withInput()->withErrors([
                'amount_received' => 'Amount received cannot exceed the net payable (PKR ' . number_format($net, 2) . ').',
            ]);
        }

        $fee = $this->fees->createInvoice([
            'branch_id'             => $this->branchId(),
            'student_id'            => $data['student_id'],
            'structure_id'          => $data['structure_id'],
            'amount'                => $data['amount'],
            'discount'              => $discount,
            'due_date'              => $data['due_date'],
            'notes'                 => $data['notes'] ?? null,
            'payment_date'          => $data['payment_date'] ?? null,
            'payment_method'        => $data['payment_method'] ?? null,
            'transaction_reference' => $data['transaction_reference'] ?? null,
        ], (int) auth()->id(), $received > 0 ? $received : null);

        if ($received > 0) {
            $payment = $fee->payments->sortByDesc('id')->first();

            return redirect()->route('accountant.payments.receipt', $payment)
                ->with('message', 'Invoice created and payment recorded.')
                ->with('alert-type', 'success');
        }

        return redirect()->route('accountant.fees.show', $fee)
            ->with('message', 'Invoice created. Collect payment when the student pays.')
            ->with('alert-type', 'success');
    }

    public function show(FeePayment $payment): View
    {
        $this->ensurePaymentInBranch($payment);

        $payment->load([
            'fee.student.studentProfile.class',
            'fee.structure.category',
            'fee.structure.schoolClass',
            'receivedBy',
        ]);

        $this->fees->decorate($payment->fee);

        return view('app.accountant.payments.show', compact('payment'));
    }

    public function receipt(FeePayment $payment): View
    {
        $this->ensurePaymentInBranch($payment);

        $payment->load([
            'fee.student.studentProfile.class',
            'fee.structure.category',
            'fee.structure.schoolClass',
            'receivedBy',
        ]);

        $this->fees->decorate($payment->fee);

        return view('app.accountant.payments.receipt', compact('payment'));
    }

    public function students(Request $request): JsonResponse
    {
        $request->validate(['class_id' => 'required|exists:classes,id']);

        $branchId = $this->branchId();

        $students = StudentProfile::with('student')
            ->where('class_id', $request->class_id)
            ->when($branchId, fn ($q) => $q->where('branch_id', $branchId))
            ->get()
            ->map(fn ($profile) => [
                'id'   => $profile->student->id,
                'name' => $profile->student->name . ' (' . ($profile->admission_no ?? 'N/A') . ')',
            ])
            ->values();

        return response()->json(['students' => $students]);
    }
}
