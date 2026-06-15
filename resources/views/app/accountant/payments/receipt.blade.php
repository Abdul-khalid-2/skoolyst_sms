<x-tenant-app-layout>
    <x-slot name="header"></x-slot>

    @php
        $currency = 'PKR ';
        $fee = $payment->fee;
        $schoolName = config('app.name');
    @endphp

    @push('css')
        <style>
            @media print {
                .no-print { display: none !important; }
                .white-box { box-shadow: none !important; border: none !important; }
                body { background: #fff !important; }
            }
            .receipt-box {
                max-width: 720px;
                margin: 0 auto;
                border: 1px solid #ddd;
                padding: 24px;
                background: #fff;
            }
            .receipt-title {
                font-size: 22px;
                font-weight: 700;
                letter-spacing: 1px;
                margin: 0;
            }
            .receipt-meta {
                color: #777;
                font-size: 13px;
            }
            .receipt-amount {
                font-size: 28px;
                font-weight: 700;
                color: #27ae60;
                margin: 10px 0 0;
            }
        </style>
    @endpush

    <div class="container-fluid" style="margin-top: 20px;">
        <div class="row no-print" style="margin-bottom: 15px;">
            <div class="col-lg-12 text-right">
                <button type="button" onclick="window.print()" class="btn btn-primary btn-sm">
                    <i class="fa fa-print"></i> Print Receipt
                </button>
                <a href="{{ route('accountant.payments.show', $payment) }}" class="btn btn-default btn-sm">
                    <i class="fa fa-eye"></i> Payment Details
                </a>
                <a href="{{ route('accountant.payments') }}" class="btn btn-default btn-sm">
                    <i class="fa fa-arrow-left"></i> Back
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                <div class="white-box">
                    <div class="receipt-box">
                        <div style="display:flex; justify-content:space-between; align-items:flex-start; border-bottom:2px solid #333; padding-bottom:15px; margin-bottom:20px;">
                            <div>
                                <p class="receipt-title">PAYMENT RECEIPT</p>
                                <p class="receipt-meta" style="margin:4px 0 0;">{{ $schoolName }}</p>
                            </div>
                            <div style="text-align:right;">
                                <p class="receipt-meta" style="margin:0;">Receipt # PAY-{{ str_pad($payment->id, 6, '0', STR_PAD_LEFT) }}</p>
                                <p class="receipt-meta" style="margin:4px 0 0;">Date: {{ $payment->payment_date ? \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') : now()->format('d M Y') }}</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <p style="margin:0 0 6px; font-size:12px; color:#888; text-transform:uppercase;">Received From</p>
                                <p style="margin:0; font-size:16px; font-weight:600;">{{ $fee->student->name ?? '—' }}</p>
                                <p class="receipt-meta" style="margin:4px 0 0;">
                                    Class: {{ $fee->student->studentProfile->class->name ?? '—' }}<br>
                                    Admission: {{ $fee->student->studentProfile->admission_no ?? '—' }}
                                </p>
                            </div>
                            <div class="col-sm-6" style="text-align:right;">
                                <p style="margin:0 0 6px; font-size:12px; color:#888; text-transform:uppercase;">Amount Received</p>
                                <p class="receipt-amount">{{ $currency }}{{ number_format($payment->amount, 2) }}</p>
                            </div>
                        </div>

                        <table class="table table-bordered" style="margin:20px 0 15px;">
                            <tbody>
                                <tr>
                                    <th style="width:35%; background:#f8f8f8;">Invoice #</th>
                                    <td>{{ $fee->invoice_number ?? '—' }}</td>
                                </tr>
                                <tr>
                                    <th style="background:#f8f8f8;">Fee Type</th>
                                    <td>{{ $fee->structure->name ?? '—' }}</td>
                                </tr>
                                <tr>
                                    <th style="background:#f8f8f8;">Payment Method</th>
                                    <td>{{ ucfirst(str_replace('_', ' ', $payment->payment_method ?? '—')) }}</td>
                                </tr>
                                <tr>
                                    <th style="background:#f8f8f8;">Transaction Reference</th>
                                    <td>{{ $payment->transaction_reference ?? '—' }}</td>
                                </tr>
                                <tr>
                                    <th style="background:#f8f8f8;">Received By</th>
                                    <td>{{ $payment->receivedBy->name ?? auth()->user()->name ?? '—' }}</td>
                                </tr>
                            </tbody>
                        </table>

                        <table class="table table-bordered" style="margin-bottom:20px;">
                            <tbody>
                                <tr>
                                    <th style="width:35%; background:#f8f8f8;">Invoice Net Payable</th>
                                    <td class="text-right">{{ $currency }}{{ number_format($fee->net_payable, 2) }}</td>
                                </tr>
                                <tr>
                                    <th style="background:#f8f8f8;">Total Paid (incl. this payment)</th>
                                    <td class="text-right">{{ $currency }}{{ number_format($fee->paid, 2) }}</td>
                                </tr>
                                <tr>
                                    <th style="background:#f8f8f8;">Remaining Balance</th>
                                    <td class="text-right {{ $fee->balance > 0 ? 'text-danger' : 'text-success' }}">
                                        <strong>{{ $currency }}{{ number_format($fee->balance, 2) }}</strong>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        @if($payment->notes)
                            <p style="font-size:13px; color:#555;"><strong>Notes:</strong> {{ $payment->notes }}</p>
                        @endif

                        <div style="border-top:1px dashed #ccc; padding-top:15px; margin-top:25px; text-align:center;">
                            <p class="receipt-meta" style="margin:0;">This is a computer-generated receipt. No signature required.</p>
                            <p class="receipt-meta" style="margin:4px 0 0;">Printed on {{ now()->format('d M Y, h:i A') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 no-print">
                <x-accountant-guide screen="payments-receipt" />
            </div>
        </div>
    </div>
</x-tenant-app-layout>
