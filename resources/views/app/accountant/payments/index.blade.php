<x-tenant-app-layout>
    <x-slot name="header"></x-slot>

    @php $currency = 'PKR '; @endphp

    <div class="container-fluid" style="margin-top: 20px;">

        <div class="row" style="margin-bottom: 15px;">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <h3 style="margin: 0; line-height: 34px;">
                    <i class="fa fa-credit-card"></i> Payment History
                </h3>
                <small class="text-muted">Filtered total: {{ $currency }}{{ number_format($totalAmount, 2) }}</small>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
                <a href="{{ route('dashboard') }}" class="btn btn-default btn-sm">
                    <i class="fa fa-arrow-left"></i> Back
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="white-box">
                    <form method="GET" action="{{ route('accountant.payments') }}" class="row" style="margin-bottom:15px;">
                        <div class="col-md-3">
                            <input type="text" name="student" class="form-control input-sm" placeholder="Student name" value="{{ request('student') }}">
                        </div>
                        <div class="col-md-2">
                            <input type="date" name="from_date" class="form-control input-sm" value="{{ request('from_date') }}">
                        </div>
                        <div class="col-md-2">
                            <input type="date" name="to_date" class="form-control input-sm" value="{{ request('to_date') }}">
                        </div>
                        <div class="col-md-2">
                            <select name="method" class="form-control input-sm">
                                <option value="">All methods</option>
                                @foreach(['cash','cheque','card','bank_transfer','online'] as $method)
                                    <option value="{{ $method }}" {{ request('method') === $method ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $method)) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-search"></i> Filter</button>
                            <a href="{{ route('accountant.payments') }}" class="btn btn-default btn-sm">Reset</a>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Student</th>
                                    <th>Invoice</th>
                                    <th>Amount</th>
                                    <th>Method</th>
                                    <th>Received By</th>
                                    <th>Reference</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($payments as $payment)
                                    <tr>
                                        <td>{{ $payment->payment_date ? \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') : '—' }}</td>
                                        <td>{{ $payment->fee->student->name ?? '—' }}</td>
                                        <td>{{ $payment->fee->invoice_number ?? '—' }}</td>
                                        <td>{{ $currency }}{{ number_format($payment->amount, 2) }}</td>
                                        <td>{{ ucfirst(str_replace('_', ' ', $payment->payment_method ?? '—')) }}</td>
                                        <td>{{ $payment->receivedBy->name ?? '—' }}</td>
                                        <td>{{ $payment->transaction_reference ?? '—' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">No payments found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{ $payments->links() }}
                </div>
            </div>
        </div>
    </div>
</x-tenant-app-layout>
