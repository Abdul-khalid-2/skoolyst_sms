<x-tenant-app-layout>
    @push('css')
        <link rel="stylesheet" href="{{ asset('backend/css/data-table/bootstrap-table.css') }}">
        <style>
            .fee-stat { background:#fff; border:1px solid #e0e0e0; border-radius:6px; padding:18px 20px; margin-bottom:20px; }
            .fee-stat h2 { margin:4px 0; font-size:26px; font-weight:700; }
            .fee-stat p  { margin:0; font-size:13px; color:#777; }
            .fee-stat.green  { border-top:3px solid #27ae60; }
            .fee-stat.red    { border-top:3px solid #e74c3c; }
            .fee-stat.blue   { border-top:3px solid #3498db; }
            .fee-stat.orange { border-top:3px solid #f39c12; }
            .quick-link { display:block; padding:12px 16px; border-radius:5px; margin-bottom:10px; color:#fff; font-weight:600; text-decoration:none; }
            .quick-link:hover { opacity:.88; color:#fff; }
            .quick-link i { margin-right:8px; }
        </style>
    @endpush
    <x-slot name="header"></x-slot>

    <div class="data-table-area mg-b-15">
        <div class="container-fluid">
            <div class="row">

                <x-page-header title="Fees Management">
                    <a href="{{ route('fees.payments.create') }}" style="color:#333;"><i class="fa fa-plus"></i> Record Payment</a>
                    <a href="{{ route('fees.categories.index') }}" style="color:#333;"><i class="fa fa-tags"></i> Categories</a>
                    <a href="{{ route('fees.structures.index') }}" style="color:#333;"><i class="fa fa-list"></i> Structures</a>
                    <a href="{{ route('fees.payments.index') }}" style="color:#333;"><i class="fa fa-history"></i> Payments</a>
                </x-page-header>

                {{-- Summary Cards --}}
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <div class="fee-stat green">
                        <p><i class="fa fa-check-circle"></i> Total Collected</p>
                        <h2>PKR {{ number_format($totalCollected, 0) }}</h2>
                        <p>All time</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <div class="fee-stat red">
                        <p><i class="fa fa-clock-o"></i> Outstanding</p>
                        <h2>PKR {{ number_format($outstanding, 0) }}</h2>
                        <p>Pending payments</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <div class="fee-stat blue">
                        <p><i class="fa fa-users"></i> Paid Students</p>
                        <h2>{{ $paidStudentsThisMonth }}</h2>
                        <p>This month</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <div class="fee-stat orange">
                        <p><i class="fa fa-exclamation-triangle"></i> Defaulters</p>
                        <h2>{{ $defaulters }}</h2>
                        <p>Overdue > 30 days</p>
                    </div>
                </div>

                {{-- Quick Actions --}}
                <div class="col-lg-4 col-md-12 col-xs-12">
                    <div class="white-box">
                        <h3 class="box-title">Quick Actions</h3>
                        <a href="{{ route('fees.payments.create') }}" class="quick-link" style="background:#27ae60;">
                            <i class="fa fa-plus"></i> Record New Payment
                        </a>
                        <a href="{{ route('fees.categories.create') }}" class="quick-link" style="background:#3498db;">
                            <i class="fa fa-tag"></i> Add Fee Category
                        </a>
                        <a href="{{ route('fees.structures.create') }}" class="quick-link" style="background:#8e44ad;">
                            <i class="fa fa-list-alt"></i> Create Fee Structure
                        </a>
                        <a href="{{ route('fees.payments.index') }}" class="quick-link" style="background:#f39c12;">
                            <i class="fa fa-history"></i> View Payment History
                        </a>
                    </div>
                </div>

                {{-- Recent Payments --}}
                <div class="col-lg-8 col-md-12 col-xs-12">
                    <div class="sparkline13-list">
                        <div class="sparkline13-hd">
                            <div class="main-sparkline13-hd">
                                <h1>Recent Payments</h1>
                            </div>
                        </div>
                        <div class="sparkline13-graph">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Invoice #</th>
                                            <th>Student</th>
                                            <th>Fee Type</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($recentPayments as $fee)
                                        <tr>
                                            <td>{{ $fee->invoice_number }}</td>
                                            <td>{{ $fee->student?->name ?? 'N/A' }}</td>
                                            <td>{{ $fee->structure?->name ?? 'N/A' }}</td>
                                            <td>PKR {{ number_format($fee->amount - $fee->discount, 2) }}</td>
                                            <td>
                                                <span class="label label-{{ $fee->status === 'paid' ? 'success' : ($fee->status === 'partial' ? 'info' : 'warning') }}">
                                                    {{ ucfirst($fee->status) }}
                                                </span>
                                            </td>
                                            <td>{{ $fee->payment_date ? \Carbon\Carbon::parse($fee->payment_date)->format('d M Y') : '—' }}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted" style="padding:30px;">
                                                <i class="fa fa-money fa-2x"></i><br>No payments recorded yet.
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
        </div>
    </div>
</x-tenant-app-layout>
