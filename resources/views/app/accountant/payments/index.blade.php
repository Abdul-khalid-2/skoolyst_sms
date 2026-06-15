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
                    <i class="fa fa-credit-card"></i> Payment History
                </h3>
                <small class="text-muted">Filtered total: <strong>{{ $currency }}{{ number_format($totalAmount, 2) }}</strong></small>
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
                    <form method="GET" action="{{ route('accountant.payments') }}">
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
                                <div class="col-lg-2 col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label>Method</label>
                                        <select name="method" class="form-control input-sm">
                                            <option value="">All methods</option>
                                            @foreach(['cash','cheque','card','bank_transfer','online'] as $method)
                                                <option value="{{ $method }}" {{ request('method') === $method ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $method)) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                    <div class="accountant-filter-actions">
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="fa fa-search"></i> Filter
                                        </button>
                                        <a href="{{ route('accountant.payments') }}" class="btn btn-default btn-sm" title="Reset">
                                            <i class="fa fa-refresh"></i> Reset
                                        </a>
                                        <a href="{{ route('accountant.payments.export.pdf', request()->query()) }}" class="btn btn-danger btn-sm" target="_blank">
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
                                    <th>Date</th>
                                    <th>Student</th>
                                    <th>Invoice</th>
                                    <th>Amount</th>
                                    <th>Method</th>
                                    <th>Received By</th>
                                    <th>Reference</th>
                                    <th class="text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($payments as $payment)
                                    <tr>
                                        <td>{{ $payment->payment_date ? \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') : '—' }}</td>
                                        <td>{{ $payment->fee->student->name ?? '—' }}</td>
                                        <td>{{ $payment->fee->invoice_number ?? '—' }}</td>
                                        <td><strong>{{ $currency }}{{ number_format($payment->amount, 2) }}</strong></td>
                                        <td>{{ ucfirst(str_replace('_', ' ', $payment->payment_method ?? '—')) }}</td>
                                        <td>{{ $payment->receivedBy->name ?? '—' }}</td>
                                        <td>{{ $payment->transaction_reference ?? '—' }}</td>
                                        <td class="text-right" style="white-space:nowrap;">
                                            <a href="{{ route('accountant.payments.show', $payment) }}" class="btn btn-default btn-xs" title="View">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <a href="{{ route('accountant.payments.receipt', $payment) }}" class="btn btn-primary btn-xs" title="Receipt">
                                                <i class="fa fa-print"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted" style="padding:30px;">
                                            <i class="fa fa-inbox fa-2x" style="color:#ddd;"></i><br>
                                            No payments found for the selected filters.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($payments->hasPages() || $payments->total() > 0)
                        <div class="accountant-pagination">
                            <div class="accountant-pagination-info">
                                Showing {{ $payments->firstItem() ?? 0 }}–{{ $payments->lastItem() ?? 0 }} of {{ $payments->total() }} payments
                            </div>
                            {{ $payments->links() }}
                        </div>
                    @endif
                </div>
            </div>

            <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                <x-accountant-guide screen="payments-index" />
            </div>
        </div>
    </div>
</x-tenant-app-layout>
