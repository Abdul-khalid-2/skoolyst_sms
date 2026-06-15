<x-tenant-app-layout>
    <x-slot name="header"></x-slot>

    @php $currency = 'PKR '; @endphp

    <div class="container-fluid" style="margin-top: 20px;">

        <div class="row" style="margin-bottom: 15px;">
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                <div class="white-box">
                    <h3 style="margin:0;"><i class="fa fa-tachometer"></i> Accountant Dashboard</h3>
                    <small class="text-muted">Fee collection overview for your branch</small>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="white-box text-right">
                    <a href="{{ route('accountant.payments.create') }}" class="btn btn-success btn-sm">
                        <i class="fa fa-plus"></i> Record Payment
                    </a>
                    <a href="{{ route('accountant.fees') }}" class="btn btn-default btn-sm">
                        <i class="fa fa-list"></i> All Invoices
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <a href="{{ route('accountant.fees') }}" style="text-decoration:none;">
                    <div class="white-box text-center">
                        <h2 class="text-info" style="margin:0;">{{ $currency }}{{ number_format($totalBilled, 0) }}</h2>
                        <small class="text-muted">Total Billed</small>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <a href="{{ route('accountant.payments') }}" style="text-decoration:none;">
                    <div class="white-box text-center">
                        <h2 class="text-success" style="margin:0;">{{ $currency }}{{ number_format($collectedFees, 0) }}</h2>
                        <small class="text-muted">Collected</small>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="white-box text-center">
                    <h2 class="{{ $outstandingFees > 0 ? 'text-danger' : 'text-success' }}" style="margin:0;">
                        {{ $currency }}{{ number_format($outstandingFees, 0) }}
                    </h2>
                    <small class="text-muted">Outstanding</small>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <a href="{{ route('accountant.reports') }}" style="text-decoration:none;">
                    <div class="white-box text-center">
                        <h2 class="text-primary" style="margin:0;">{{ $feeCollectionRate }}%</h2>
                        <small class="text-muted">Collection Rate</small>
                    </div>
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="white-box">
                            <h3 class="box-title"><i class="fa fa-exclamation-circle"></i> Pending Overview</h3>
                            <p><strong>{{ $pendingCount }}</strong> pending/partial invoices</p>
                            <p><strong class="text-danger">{{ $overdueCount }}</strong> overdue invoices</p>
                            <a href="{{ route('accountant.fees', ['status' => 'pending']) }}" class="btn btn-default btn-sm">View Pending Fees</a>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="white-box">
                            <h3 class="box-title"><i class="fa fa-history"></i> Recent Payments</h3>
                            @if($recentPayments->isEmpty())
                                <p class="text-muted">No payments recorded yet.</p>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Student</th>
                                                <th>Amount</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($recentPayments as $payment)
                                                <tr>
                                                    <td>{{ $payment->payment_date ? \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') : '—' }}</td>
                                                    <td>{{ $payment->fee->student->name ?? '—' }}</td>
                                                    <td>{{ $currency }}{{ number_format($payment->amount, 2) }}</td>
                                                    <td class="text-right">
                                                        <a href="{{ route('accountant.payments.receipt', $payment) }}" class="btn btn-default btn-xs">
                                                            <i class="fa fa-print"></i>
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
                </div>
            </div>

            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                <x-accountant-guide screen="dashboard" />
            </div>
        </div>
    </div>
</x-tenant-app-layout>
