<?php

namespace App\Services\Accountant;

use App\Models\Fee;
use App\Models\FeePayment;
use App\Services\Fees\FeePaymentService;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;

class AccountantReportService
{
    public function __construct(
        private FeePaymentService $fees,
    ) {}

    public function feesQuery(Request $request, ?int $branchId): Builder
    {
        $query = Fee::when($branchId, fn ($q) => $q->where('branch_id', $branchId))
            ->with(['student.studentProfile.class', 'structure.category', 'structure.schoolClass', 'payments']);

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

        return $query->orderByDesc('due_date');
    }

    public function paymentsQuery(Request $request, ?int $branchId): Builder
    {
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

        return $query->orderByDesc('payment_date')->orderByDesc('id');
    }

    public function downloadFeesPdf(Request $request, ?int $branchId): Response
    {
        $fees = $this->feesQuery($request, $branchId)->get()
            ->each(fn (Fee $fee) => $this->fees->decorate($fee));

        $totals = [
            'payable' => round($fees->sum('net_payable'), 2),
            'paid'    => round($fees->sum('paid'), 2),
            'balance' => round($fees->sum('balance'), 2),
        ];

        $filters = $this->filterSummary($request, [
            'student'   => 'Student',
            'status'    => 'Status',
            'from_date' => 'From',
            'to_date'   => 'To',
        ]);

        $html = view('app.accountant.reports.pdf.fees', compact('fees', 'totals', 'filters'))->render();

        return $this->pdfResponse($html, 'fees-report-'.now()->format('Y-m-d-His').'.pdf');
    }

    public function downloadPaymentsPdf(Request $request, ?int $branchId): Response
    {
        $payments = $this->paymentsQuery($request, $branchId)->get();
        $totalAmount = round((float) $payments->sum('amount'), 2);

        $filters = $this->filterSummary($request, [
            'student'   => 'Student',
            'from_date' => 'From',
            'to_date'   => 'To',
            'method'    => 'Method',
        ]);

        $html = view('app.accountant.reports.pdf.payments', compact('payments', 'totalAmount', 'filters'))->render();

        return $this->pdfResponse($html, 'payments-report-'.now()->format('Y-m-d-His').'.pdf');
    }

    private function filterSummary(Request $request, array $keys): array
    {
        $filters = [];

        foreach ($keys as $key => $label) {
            if ($request->filled($key)) {
                $value = $request->input($key);
                if ($key === 'method') {
                    $value = ucfirst(str_replace('_', ' ', $value));
                } elseif (in_array($key, ['from_date', 'to_date'], true)) {
                    $value = Carbon::parse($value)->format('d M Y');
                } elseif ($key === 'status') {
                    $value = ucfirst($value);
                }
                $filters[$label] = $value;
            }
        }

        return $filters;
    }

    private function pdfResponse(string $html, string $filename): Response
    {
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('defaultFont', 'DejaVu Sans');

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        return response($dompdf->output(), 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
        ]);
    }
}
