<x-tenant-app-layout>
    <x-slot name="header"></x-slot>

    @php $currency = 'PKR '; @endphp

    @push('css')
        <x-accountant-styles />
    @endpush

    <div class="container-fluid" style="margin-top: 20px;">
        <div class="row" style="margin-bottom: 15px;">
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                <h3 style="margin: 0; line-height: 34px;">
                    <i class="fa fa-file-text-o"></i> Invoice {{ $fee->invoice_number ?? '—' }}
                </h3>
                <small class="text-muted">Fee invoice details and payment history</small>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 text-right">
                @if($fee->status !== 'cancelled' && $fee->balance > 0)
                    <a href="{{ route('accountant.fees.collect', $fee) }}" class="btn btn-success btn-sm">
                        <i class="fa fa-money"></i> Collect Payment
                    </a>
                @endif
                <a href="{{ route('accountant.fees') }}" class="btn btn-default btn-sm">
                    <i class="fa fa-arrow-left"></i> Back
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                <div class="white-box">
                    <div style="display:flex; justify-content:space-between; align-items:flex-start; border-bottom:2px solid #eee; padding-bottom:15px; margin-bottom:20px;">
                        <div>
                            <h4 style="margin:0;">Fee Invoice</h4>
                            <small class="text-muted">Due {{ $fee->due_date ? \Carbon\Carbon::parse($fee->due_date)->format('d M Y') : '—' }}</small>
                            @if($fee->is_overdue)
                                <br><span class="label label-danger">Overdue</span>
                            @endif
                        </div>
                        <div>
                            @switch($fee->status)
                                @case('paid') <span class="label label-success">Paid</span> @break
                                @case('partial') <span class="label label-warning">Partial</span> @break
                                @case('pending') <span class="label label-default">Pending</span> @break
                                @case('cancelled') <span class="label label-danger">Cancelled</span> @break
                                @default <span class="label label-default">{{ ucfirst($fee->status ?? '—') }}</span>
                            @endswitch
                        </div>
                    </div>

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
                            <h5 style="color:#555;">Fee Details</h5>
                            <table class="table table-bordered table-condensed">
                                <tr><th style="width:40%">Fee Type</th><td>{{ $fee->structure->name ?? '—' }}</td></tr>
                                <tr><th>Category</th><td>{{ $fee->structure->category->name ?? '—' }}</td></tr>
                                <tr><th>Class</th><td>{{ $fee->structure->schoolClass->name ?? 'All classes' }}</td></tr>
                            </table>
                        </div>
                    </div>

                    <h5 style="color:#555;">Amount Summary</h5>
                    <table class="table table-bordered">
                        <tr><th>Fee Amount</th><td class="text-right">{{ $currency }}{{ number_format($fee->amount, 2) }}</td></tr>
                        <tr><th>Discount</th><td class="text-right text-danger">- {{ $currency }}{{ number_format($fee->discount, 2) }}</td></tr>
                        <tr style="background:#f8f8f8;"><th>Net Payable</th><td class="text-right"><strong>{{ $currency }}{{ number_format($fee->net_payable, 2) }}</strong></td></tr>
                        <tr><th>Paid</th><td class="text-right text-success">{{ $currency }}{{ number_format($fee->paid, 2) }}</td></tr>
                        <tr><th>Balance</th><td class="text-right {{ $fee->balance > 0 ? 'text-danger' : 'text-success' }}"><strong>{{ $currency }}{{ number_format($fee->balance, 2) }}</strong></td></tr>
                    </table>

                    @if($fee->notes)
                        <p><strong>Notes:</strong> {{ $fee->notes }}</p>
                    @endif
                </div>

                <div class="white-box">
                    <h3 class="box-title"><i class="fa fa-history"></i> Payment History</h3>
                    @if($fee->payments->isEmpty())
                        <p class="text-muted">No payments recorded for this invoice yet.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <th>Method</th>
                                        <th>Received By</th>
                                        <th>Reference</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($fee->payments->sortByDesc('payment_date') as $payment)
                                        <tr>
                                            <td>{{ $payment->payment_date ? \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') : '—' }}</td>
                                            <td>{{ $currency }}{{ number_format($payment->amount, 2) }}</td>
                                            <td>{{ ucfirst(str_replace('_', ' ', $payment->payment_method ?? '—')) }}</td>
                                            <td>{{ $payment->receivedBy->name ?? '—' }}</td>
                                            <td>{{ $payment->transaction_reference ?? '—' }}</td>
                                            <td class="text-right">
                                                <a href="{{ route('accountant.payments.receipt', $payment) }}" class="btn btn-default btn-xs">
                                                    <i class="fa fa-print"></i> Receipt
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                <x-accountant-guide screen="fees-show" />

                <div class="white-box">
                    <h5 style="margin-top:0;"><i class="fa fa-bolt"></i> Quick Actions</h5>
                    @if($fee->status !== 'cancelled' && $fee->balance > 0)
                        <a href="{{ route('accountant.fees.collect', $fee) }}" class="btn btn-success btn-block" style="margin-bottom:8px;">
                            <i class="fa fa-money"></i> Collect {{ $currency }}{{ number_format($fee->balance, 2) }}
                        </a>
                    @endif
                    <a href="{{ route('accountant.payments.create') }}" class="btn btn-primary btn-block" style="margin-bottom:8px;">
                        <i class="fa fa-plus"></i> New Invoice & Payment
                    </a>
                    <a href="{{ route('accountant.fees') }}" class="btn btn-default btn-block">
                        <i class="fa fa-list"></i> All Invoices
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-tenant-app-layout>
