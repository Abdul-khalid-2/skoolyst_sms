<x-tenant-app-layout>
    <x-slot name="header"></x-slot>

    @php $currency = 'PKR '; @endphp

    <div class="container-fluid" style="margin-top: 20px;">

        <div class="row" style="margin-bottom: 15px;">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <h3 style="margin: 0; line-height: 34px;">
                    <i class="fa fa-money"></i> Fee Invoices
                </h3>
                <small class="text-muted">Branch fee records</small>
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
                    <form method="GET" action="{{ route('accountant.fees') }}" class="row" style="margin-bottom:15px;">
                        <div class="col-md-3">
                            <input type="text" name="student" class="form-control input-sm" placeholder="Student name" value="{{ request('student') }}">
                        </div>
                        <div class="col-md-2">
                            <select name="status" class="form-control input-sm">
                                <option value="">All statuses</option>
                                @foreach(['pending','partial','paid','cancelled'] as $status)
                                    <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <input type="date" name="from_date" class="form-control input-sm" value="{{ request('from_date') }}">
                        </div>
                        <div class="col-md-2">
                            <input type="date" name="to_date" class="form-control input-sm" value="{{ request('to_date') }}">
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-search"></i> Filter</button>
                            <a href="{{ route('accountant.fees') }}" class="btn btn-default btn-sm">Reset</a>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
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
                                                <br><small class="text-danger">Overdue</small>
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
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted">No fee records found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{ $fees->links() }}
                </div>
            </div>
        </div>
    </div>
</x-tenant-app-layout>
