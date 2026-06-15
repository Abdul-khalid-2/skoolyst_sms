<?php

namespace App\Http\Controllers\Accountant;

use App\Http\Controllers\Accountant\Concerns\ScopesAccountantBranch;
use App\Http\Controllers\Controller;
use App\Models\Fee;
use App\Services\Accountant\AccountantReportService;
use App\Services\Fees\FeePaymentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class FeeController extends Controller
{
    use ScopesAccountantBranch;

    public function __construct(
        private FeePaymentService $fees,
        private AccountantReportService $reports,
    ) {}

    public function index(Request $request): View
    {
        $fees = $this->reports->feesQuery($request, $this->branchId())
            ->paginate(20)
            ->withQueryString();

        $fees->getCollection()->transform(fn (Fee $fee) => $this->fees->decorate($fee));

        return view('app.accountant.fees.index', compact('fees'));
    }

    public function exportPdf(Request $request): Response
    {
        return $this->reports->downloadFeesPdf($request, $this->branchId());
    }

    public function show(Fee $fee): View
    {
        $this->ensureFeeInBranch($fee);

        $fee->load([
            'student.studentProfile.class',
            'structure.category',
            'structure.schoolClass',
            'payments.receivedBy',
        ]);

        $this->fees->decorate($fee);

        return view('app.accountant.fees.show', compact('fee'));
    }

    public function collect(Fee $fee): View|RedirectResponse
    {
        $this->ensureFeeInBranch($fee);

        $fee->load(['student', 'structure.category', 'payments']);
        $this->fees->decorate($fee);

        if ($fee->status === 'cancelled') {
            return redirect()->route('accountant.fees.show', $fee)
                ->with('message', 'This invoice is cancelled.')
                ->with('alert-type', 'warning');
        }

        if ($fee->balance <= 0) {
            return redirect()->route('accountant.fees.show', $fee)
                ->with('message', 'This invoice is already fully paid.')
                ->with('alert-type', 'info');
        }

        return view('app.accountant.fees.collect', compact('fee'));
    }

    public function storeCollect(Request $request, Fee $fee): RedirectResponse
    {
        $this->ensureFeeInBranch($fee);

        $data = $request->validate([
            'amount'                => 'required|numeric|min:0.01',
            'payment_date'          => 'required|date',
            'payment_method'        => 'required|in:cash,cheque,card,bank_transfer,online',
            'transaction_reference' => 'nullable|string|max:100',
            'notes'                 => 'nullable|string',
        ]);

        $payment = $this->fees->recordPayment($fee, $data, (int) auth()->id());

        return redirect()->route('accountant.payments.receipt', $payment)
            ->with('message', 'Payment recorded successfully.')
            ->with('alert-type', 'success');
    }
}
