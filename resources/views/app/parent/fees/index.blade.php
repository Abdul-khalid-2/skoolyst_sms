<x-tenant-app-layout>
    <x-slot name="header"></x-slot>

    @php $currency = 'PKR '; @endphp

    <div class="container-fluid" style="margin-top: 20px;">

        <div class="row" style="margin-bottom: 15px;">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <h3 style="margin: 0; line-height: 34px;">
                    <i class="fa fa-credit-card"></i> Fee Payments
                </h3>
                <small class="text-muted">Fee status across all linked children</small>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
                <a href="{{ route('dashboard') }}" class="btn btn-default btn-sm">
                    <i class="fa fa-arrow-left"></i> Back
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="white-box text-center">
                    <h2 class="text-info" style="margin:0;">{{ $currency }}{{ number_format($summary['total_billed'], 2) }}</h2>
                    <small class="text-muted">Total Billed</small>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="white-box text-center">
                    <h2 class="text-success" style="margin:0;">{{ $currency }}{{ number_format($summary['total_paid'], 2) }}</h2>
                    <small class="text-muted">Total Paid</small>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="white-box text-center">
                    <h2 class="{{ $summary['total_outstanding'] > 0 ? 'text-danger' : 'text-success' }}" style="margin:0;">
                        {{ $currency }}{{ number_format($summary['total_outstanding'], 2) }}
                    </h2>
                    <small class="text-muted">Outstanding</small>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="white-box text-center">
                    <h2 class="{{ $summary['overdue_count'] > 0 ? 'text-danger' : 'text-success' }}" style="margin:0;">
                        {{ $summary['overdue_count'] }}
                    </h2>
                    <small class="text-muted">Overdue Invoices</small>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="white-box">
                    <h3 class="box-title"><i class="fa fa-file-text-o"></i> Fee Invoices</h3>

                    @if($fees->isEmpty())
                        <p class="text-muted text-center" style="padding: 30px 0;">No fee records found.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Student</th>
                                        <th>Invoice #</th>
                                        <th>Fee Type</th>
                                        <th>Due Date</th>
                                        <th>Payable</th>
                                        <th>Paid</th>
                                        <th>Balance</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($fees as $fee)
                                        <tr>
                                            <td>{{ $fee->student->name ?? '—' }}</td>
                                            <td>{{ $fee->invoice_number ?? '—' }}</td>
                                            <td>{{ $fee->structure->name ?? ($fee->structure->category->name ?? 'Fee') }}</td>
                                            <td>
                                                {{ $fee->due_date ? \Carbon\Carbon::parse($fee->due_date)->format('d M Y') : '—' }}
                                                @if($fee->is_overdue)
                                                    <br><small class="text-danger"><i class="fa fa-exclamation-circle"></i> Overdue</small>
                                                @endif
                                            </td>
                                            <td>{{ $currency }}{{ number_format($fee->net_payable, 2) }}</td>
                                            <td>{{ $currency }}{{ number_format($fee->paid, 2) }}</td>
                                            <td class="{{ $fee->balance > 0 ? 'text-danger' : 'text-success' }}">
                                                {{ $currency }}{{ number_format($fee->balance, 2) }}
                                            </td>
                                            <td>
                                                @switch($fee->status)
                                                    @case('paid') <span class="label label-success">Paid</span> @break
                                                    @case('partial') <span class="label label-warning">Partial</span> @break
                                                    @case('pending') <span class="label label-default">Pending</span> @break
                                                    @case('cancelled') <span class="label label-danger">Cancelled</span> @break
                                                    @default <span class="label label-default">{{ ucfirst($fee->status ?? '—') }}</span>
                                                @endswitch
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-tenant-app-layout>
