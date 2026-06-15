<x-tenant-app-layout>
    <x-slot name="header"></x-slot>

    @php
        $currency = 'PKR ';
        $fee = $payment->fee;
    @endphp

    @push('css')
        <x-accountant-styles />
    @endpush

    <div class="container-fluid" style="margin-top: 20px;">
        <div class="row" style="margin-bottom: 15px;">
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                <h3 style="margin: 0; line-height: 34px;">
                    <i class="fa fa-credit-card"></i> Payment #{{ $payment->id }}
                </h3>
                <small class="text-muted">Invoice {{ $fee->invoice_number ?? '—' }}</small>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 text-right">
                <a href="{{ route('accountant.payments.receipt', $payment) }}" class="btn btn-primary btn-sm">
                    <i class="fa fa-print"></i> Print Receipt
                </a>
                <a href="{{ route('accountant.payments') }}" class="btn btn-default btn-sm">
                    <i class="fa fa-arrow-left"></i> Back
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                <div class="white-box">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 style="color:#555;">Student</h5>
                            <table class="table table-bordered table-condensed">
                                <tr><th style="width:40%">Name</th><td>{{ $fee->student->name ?? '—' }}</td></tr>
                                <tr><th>Class</th><td>{{ $fee->student->studentProfile->class->name ?? '—' }}</td></tr>
                                <tr><th>Admission No</th><td>{{ $fee->student->studentProfile->admission_no ?? '—' }}</td></tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5 style="color:#555;">Invoice</h5>
                            <table class="table table-bordered table-condensed">
                                <tr><th style="width:40%">Invoice #</th><td>{{ $fee->invoice_number ?? '—' }}</td></tr>
                                <tr><th>Fee Type</th><td>{{ $fee->structure->name ?? '—' }}</td></tr>
                                <tr><th>Invoice Status</th><td>{{ ucfirst($fee->status ?? '—') }}</td></tr>
                            </table>
                        </div>
                    </div>

                    <h5 style="color:#555;">Payment Details</h5>
                    <table class="table table-bordered">
                        <tr><th style="width:35%">Payment Date</th><td>{{ $payment->payment_date ? \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') : '—' }}</td></tr>
                        <tr><th>Amount Paid</th><td><strong>{{ $currency }}{{ number_format($payment->amount, 2) }}</strong></td></tr>
                        <tr><th>Method</th><td>{{ ucfirst(str_replace('_', ' ', $payment->payment_method ?? '—')) }}</td></tr>
                        <tr><th>Transaction Reference</th><td>{{ $payment->transaction_reference ?? '—' }}</td></tr>
                        <tr><th>Received By</th><td>{{ $payment->receivedBy->name ?? '—' }}</td></tr>
                        @if($payment->notes)
                            <tr><th>Notes</th><td>{{ $payment->notes }}</td></tr>
                        @endif
                    </table>

                    <h5 style="color:#555;">Invoice Balance After Payment</h5>
                    <table class="table table-bordered">
                        <tr><th>Net Payable</th><td class="text-right">{{ $currency }}{{ number_format($fee->net_payable, 2) }}</td></tr>
                        <tr><th>Total Paid</th><td class="text-right">{{ $currency }}{{ number_format($fee->paid, 2) }}</td></tr>
                        <tr><th>Remaining Balance</th><td class="text-right {{ $fee->balance > 0 ? 'text-danger' : 'text-success' }}"><strong>{{ $currency }}{{ number_format($fee->balance, 2) }}</strong></td></tr>
                    </table>

                    <div style="display:flex; gap:10px; flex-wrap:wrap;">
                        <a href="{{ route('accountant.payments.receipt', $payment) }}" class="btn btn-primary">
                            <i class="fa fa-print"></i> Print Receipt
                        </a>
                        <a href="{{ route('accountant.fees.show', $fee) }}" class="btn btn-default">
                            <i class="fa fa-file-text-o"></i> View Invoice
                        </a>
                        @if($fee->balance > 0 && $fee->status !== 'cancelled')
                            <a href="{{ route('accountant.fees.collect', $fee) }}" class="btn btn-success">
                                <i class="fa fa-money"></i> Collect Remaining
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                <x-accountant-guide screen="payments-show" />
            </div>
        </div>
    </div>
</x-tenant-app-layout>
