<x-tenant-app-layout>
    <x-slot name="header"></x-slot>

    @php
        $profile = $student->studentProfile;
        $className = $profile->class->name ?? '—';
        $sectionName = $profile->section->name ?? '—';
        $currency = 'PKR ';
    @endphp

    <div class="container-fluid" style="margin-top: 20px;">

        {{-- Header --}}
        <div class="row" style="margin-bottom: 15px;">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <h3 style="margin: 0; line-height: 34px;">
                    <i class="fa fa-file-text-o"></i> Invoice {{ $fee->invoice_number ?? '' }}
                </h3>
                <small class="text-muted">
                    {{ $fee->structure->name ?? ($fee->structure->category->name ?? 'Fee') }}
                </small>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
                <a href="{{ route('student.fees') }}" class="btn btn-default btn-sm">
                    <i class="fa fa-arrow-left"></i> Back to Fees
                </a>
            </div>
        </div>

        <div class="row">
            {{-- Invoice details --}}
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="white-box">
                    <h3 class="box-title"><i class="fa fa-info-circle"></i> Invoice Details</h3>
                    <table class="table table-condensed" style="margin-bottom:0;">
                        <tbody>
                            <tr>
                                <th style="width:45%; border-top:none;">Student</th>
                                <td style="border-top:none;">{{ $student->name }} ({{ $className }} - {{ $sectionName }})</td>
                            </tr>
                            <tr>
                                <th>Invoice #</th>
                                <td>{{ $fee->invoice_number ?? '—' }}</td>
                            </tr>
                            <tr>
                                <th>Fee Type</th>
                                <td>{{ $fee->structure->name ?? '—' }}</td>
                            </tr>
                            <tr>
                                <th>Category</th>
                                <td>{{ $fee->structure->category->name ?? '—' }}</td>
                            </tr>
                            <tr>
                                <th>Due Date</th>
                                <td>
                                    {{ $fee->due_date ? \Carbon\Carbon::parse($fee->due_date)->format('d M Y') : '—' }}
                                    @if($fee->is_overdue)
                                        <span class="label label-danger">Overdue</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    @switch($fee->status)
                                        @case('paid')
                                            <span class="label label-success">Paid</span>
                                            @break
                                        @case('partial')
                                            <span class="label label-warning">Partial</span>
                                            @break
                                        @case('pending')
                                            <span class="label label-default">Pending</span>
                                            @break
                                        @case('cancelled')
                                            <span class="label label-danger">Cancelled</span>
                                            @break
                                        @default
                                            <span class="label label-default">{{ ucfirst($fee->status ?? '—') }}</span>
                                    @endswitch
                                </td>
                            </tr>
                            @if($fee->notes)
                            <tr>
                                <th>Notes</th>
                                <td>{{ $fee->notes }}</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Amount breakdown --}}
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="white-box">
                    <h3 class="box-title"><i class="fa fa-calculator"></i> Amount Summary</h3>
                    <table class="table table-condensed" style="margin-bottom:0;">
                        <tbody>
                            <tr>
                                <th style="width:55%; border-top:none;">Gross Amount</th>
                                <td style="border-top:none;" class="text-right">{{ $currency }}{{ number_format($fee->amount, 2) }}</td>
                            </tr>
                            <tr>
                                <th>Discount</th>
                                <td class="text-right">- {{ $currency }}{{ number_format($fee->discount, 2) }}</td>
                            </tr>
                            <tr>
                                <th>Net Payable</th>
                                <td class="text-right"><strong>{{ $currency }}{{ number_format($fee->net_payable, 2) }}</strong></td>
                            </tr>
                            <tr>
                                <th>Total Paid</th>
                                <td class="text-right text-success">{{ $currency }}{{ number_format($fee->paid, 2) }}</td>
                            </tr>
                            <tr style="background:#f9f9f9;">
                                <th>Balance Due</th>
                                <td class="text-right">
                                    <strong class="{{ $fee->balance > 0 ? 'text-danger' : 'text-success' }}">
                                        {{ $currency }}{{ number_format($fee->balance, 2) }}
                                    </strong>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Payment history --}}
        <div class="row" style="margin-top: 15px;">
            <div class="col-lg-12">
                <div class="white-box">
                    <h3 class="box-title"><i class="fa fa-history"></i> Payment History</h3>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Method</th>
                                    <th>Reference</th>
                                    <th>Received By</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($fee->payments as $index => $payment)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $payment->payment_date ? \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') : '—' }}</td>
                                        <td>{{ $currency }}{{ number_format($payment->amount, 2) }}</td>
                                        <td>{{ $payment->payment_method ? ucwords(str_replace('_', ' ', $payment->payment_method)) : '—' }}</td>
                                        <td>{{ $payment->transaction_reference ?? '—' }}</td>
                                        <td>{{ $payment->receivedBy->name ?? '—' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted" style="padding: 20px 0;">
                                            <i class="fa fa-inbox fa-2x" style="display:block; margin-bottom:8px;"></i>
                                            No payments recorded against this invoice yet.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-tenant-app-layout>
