<x-tenant-app-layout>
    @push('css')
        <link rel="stylesheet" href="{{ asset('backend/css/data-table/bootstrap-table.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/datapicker/datepicker3.css') }}">
        <style>
            .filter-card { background:#fff; border:1px solid #e0e0e0; border-radius:6px; padding:18px 20px; margin-bottom:20px; }
            .filter-card label { font-weight:600; font-size:13px; color:#555; }
            .status-paid     { background:#e6f9ee; color:#27ae60; padding:3px 10px; border-radius:20px; font-size:12px; font-weight:600; }
            .status-pending  { background:#fff8e1; color:#f39c12; padding:3px 10px; border-radius:20px; font-size:12px; font-weight:600; }
            .status-partial  { background:#e8f4fd; color:#3498db; padding:3px 10px; border-radius:20px; font-size:12px; font-weight:600; }
            .status-cancelled{ background:#fdecea; color:#e74c3c; padding:3px 10px; border-radius:20px; font-size:12px; font-weight:600; }
        </style>
    @endpush
    <x-slot name="header"></x-slot>

    <div class="data-table-area mg-b-15">
        <div class="container-fluid">
            <div class="row">

                <x-page-header title="Fee Payments">
                    <a href="{{ route('fees.payments.create') }}" style="color:#333;"><i class="fa fa-plus"></i> Record Payment</a>
                    <a href="{{ route('fees.index') }}" style="color:#333;"><i class="fa fa-tachometer"></i> Fees Dashboard</a>
                </x-page-header>

                {{-- Filters --}}
                <div class="col-lg-12">
                    <form method="GET" action="{{ route('fees.payments.index') }}">
                        <div class="filter-card">
                            <div class="row">
                                <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label>Student Name</label>
                                        <input type="text" name="student" class="form-control input-sm" placeholder="Search..." value="{{ request('student') }}">
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label>From Date</label>
                                        <input type="text" name="from_date" class="form-control input-sm datepicker" placeholder="YYYY-MM-DD" value="{{ request('from_date') }}">
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label>To Date</label>
                                        <input type="text" name="to_date" class="form-control input-sm datepicker" placeholder="YYYY-MM-DD" value="{{ request('to_date') }}">
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select name="status" class="form-control input-sm">
                                            <option value="">All</option>
                                            <option value="paid"      {{ request('status') === 'paid'      ? 'selected' : '' }}>Paid</option>
                                            <option value="pending"   {{ request('status') === 'pending'   ? 'selected' : '' }}>Pending</option>
                                            <option value="partial"   {{ request('status') === 'partial'   ? 'selected' : '' }}>Partial</option>
                                            <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label>&nbsp;</label>
                                        <div style="display:flex; gap:6px;">
                                            <button type="submit" class="btn btn-primary btn-sm btn-block">
                                                <i class="fa fa-search"></i> Filter
                                            </button>
                                            <a href="{{ route('fees.payments.index') }}" class="btn btn-default btn-sm" title="Reset">
                                                <i class="fa fa-refresh"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                {{-- Table --}}
                <div class="col-lg-12">
                    <div class="sparkline13-list">
                        <div class="sparkline13-graph">
                            <div class="datatable-dashv1-list custom-datatable-overright">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered hover-table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Invoice #</th>
                                                <th>Student</th>
                                                <th>Class</th>
                                                <th>Fee Type</th>
                                                <th>Amount</th>
                                                <th>Discount</th>
                                                <th>Net Payable</th>
                                                <th>Due Date</th>
                                                <th>Status</th>
                                                <th>Payment Method</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($payments as $i => $fee)
                                            @php $net = $fee->amount - $fee->discount; @endphp
                                            <tr>
                                                <td>{{ $payments->firstItem() + $i }}</td>
                                                <td><small>{{ $fee->invoice_number }}</small></td>
                                                <td>{{ $fee->student?->name ?? 'N/A' }}</td>
                                                <td>{{ $fee->structure?->schoolClass?->name ?? 'All' }}</td>
                                                <td>{{ $fee->structure?->name ?? 'N/A' }}</td>
                                                <td>PKR {{ number_format($fee->amount, 2) }}</td>
                                                <td>{{ $fee->discount > 0 ? 'PKR '.number_format($fee->discount,2) : '—' }}</td>
                                                <td><strong>PKR {{ number_format($net, 2) }}</strong></td>
                                                <td>{{ \Carbon\Carbon::parse($fee->due_date)->format('d M Y') }}</td>
                                                <td>
                                                    <span class="status-{{ $fee->status }}">{{ ucfirst($fee->status) }}</span>
                                                </td>
                                                <td>{{ $fee->payment_method ? ucfirst(str_replace('_',' ',$fee->payment_method)) : '—' }}</td>
                                                <td>
                                                    <div style="display:flex; gap:4px;">
                                                        <a href="{{ route('fees.payments.show', $fee) }}" class="btn btn-xs btn-success" title="View">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                        <form action="{{ route('fees.payments.destroy', $fee) }}" method="POST">
                                                            @csrf @method('DELETE')
                                                            <button class="btn btn-xs btn-danger" title="Delete"
                                                                onclick="return confirm('Delete this record?')">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="12" class="text-center text-muted" style="padding:30px;">
                                                    <i class="fa fa-money fa-2x"></i><br>No payment records found.
                                                    @if(request()->hasAny(['student','from_date','to_date','status']))
                                                        <br><a href="{{ route('fees.payments.index') }}">Clear filters</a>
                                                    @else
                                                        <br><a href="{{ route('fees.payments.create') }}">Record the first payment</a>
                                                    @endif
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
    </div>

    @push('js')
        <script>
            $(document).ready(function () {
                if ($.fn.datepicker) {
                    $('.datepicker').datepicker({ format: 'yyyy-mm-dd', autoclose: true });
                }
            });
        </script>
        @if($payments->hasPages())
            <div style="margin-top:15px; padding:0 20px;">
                {{ $payments->links() }}
            </div>
        @endif
    @endpush
</x-tenant-app-layout>
