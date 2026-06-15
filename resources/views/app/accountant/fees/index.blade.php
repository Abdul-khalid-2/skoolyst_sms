<x-tenant-app-layout>
    <x-slot name="header"></x-slot>

    @php $currency = 'PKR '; @endphp

    @push('css')
        <x-accountant-styles />
    @endpush

    <div class="container-fluid" style="margin-top: 20px;">

        <div class="row" style="margin-bottom: 15px;">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <h3 style="margin: 0; line-height: 34px;">
                    <i class="fa fa-money"></i> Fee Invoices
                </h3>
                <small class="text-muted">Branch fee records</small>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
                <a href="{{ route('accountant.payments.create') }}" class="btn btn-success btn-sm">
                    <i class="fa fa-plus"></i> Record Payment
                </a>
                <a href="{{ route('dashboard') }}" class="btn btn-default btn-sm">
                    <i class="fa fa-arrow-left"></i> Back
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12">
                <div class="white-box">
                    <form method="GET" action="{{ route('accountant.fees') }}">
                        <div class="accountant-filter-card">
                            <div class="row">
                                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label>Student Name</label>
                                        <input type="text" name="student" class="form-control input-sm" placeholder="Search student..." value="{{ request('student') }}">
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select name="status" class="form-control input-sm">
                                            <option value="">All statuses</option>
                                            @foreach(['pending','partial','paid','cancelled'] as $status)
                                                <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label>From Date</label>
                                        <input type="date" name="from_date" class="form-control input-sm" value="{{ request('from_date') }}">
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label>To Date</label>
                                        <input type="date" name="to_date" class="form-control input-sm" value="{{ request('to_date') }}">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                    <div class="accountant-filter-actions">
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="fa fa-search"></i> Filter
                                        </button>
                                        <a href="{{ route('accountant.fees') }}" class="btn btn-default btn-sm" title="Reset">
                                            <i class="fa fa-refresh"></i> Reset
                                        </a>
                                        <a href="{{ route('accountant.fees.export.pdf', request()->query()) }}" class="btn btn-danger btn-sm" target="_blank">
                                            <i class="fa fa-file-pdf-o"></i> PDF Report
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Invoice #</th>
                                    <th>Student</th>
                                    <th>Fee Type</th>
                                    <th>Due Date</th>
                                    <th>Payable</th>
                                    <th>Paid</th>
                                    <th>Balance</th>
                                    <th>Status</th>
                                    <th class="text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($fees as $fee)
                                    <tr>
                                        <td>{{ $fee->invoice_number ?? '—' }}</td>
                                        <td>{{ $fee->student->name ?? '—' }}</td>
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
                                            <strong>{{ $currency }}{{ number_format($fee->balance, 2) }}</strong>
                                        </td>
                                        <td>
                                            @switch($fee->status)
                                                @case('paid') <span class="fee-status-paid">Paid</span> @break
                                                @case('partial') <span class="fee-status-partial">Partial</span> @break
                                                @case('pending') <span class="fee-status-pending">Pending</span> @break
                                                @case('cancelled') <span class="fee-status-cancelled">Cancelled</span> @break
                                                @default <span class="fee-status-pending">{{ ucfirst($fee->status ?? '—') }}</span>
                                            @endswitch
                                        </td>
                                        <td class="text-right" style="white-space:nowrap;">
                                            <a href="{{ route('accountant.fees.show', $fee) }}" class="btn btn-default btn-xs" title="View">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            @if($fee->status !== 'cancelled' && $fee->balance > 0)
                                                <a href="{{ route('accountant.fees.collect', $fee) }}" class="btn btn-success btn-xs" title="Collect">
                                                    <i class="fa fa-money"></i>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center text-muted" style="padding:30px;">
                                            <i class="fa fa-inbox fa-2x" style="color:#ddd;"></i><br>
                                            No fee records found for the selected filters.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($fees->hasPages() || $fees->total() > 0)
                        <div class="accountant-pagination">
                            <div class="accountant-pagination-info">
                                Showing {{ $fees->firstItem() ?? 0 }}–{{ $fees->lastItem() ?? 0 }} of {{ $fees->total() }} invoices
                            </div>
                            {{ $fees->links() }}
                        </div>
                    @endif
                </div>
            </div>

            <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                <x-accountant-guide screen="fees-index" />
            </div>
        </div>
    </div>
</x-tenant-app-layout>
