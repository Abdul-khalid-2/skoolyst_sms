<x-tenant-app-layout>
    @push('css')
        <link rel="stylesheet" href="{{ asset('backend/css/data-table/bootstrap-table.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/datapicker/datepicker3.css') }}">
        <style>
            .filter-card { background:#fff; border:1px solid #e0e0e0; border-radius:6px; padding:16px 20px; margin-bottom:20px; }
            .filter-card label { font-weight:600; font-size:13px; color:#555; }
            .tt-purchase   { background:#e6f9ee; color:#27ae60; padding:3px 9px; border-radius:20px; font-size:12px; font-weight:600; }
            .tt-issue      { background:#e8f4fd; color:#3498db; padding:3px 9px; border-radius:20px; font-size:12px; font-weight:600; }
            .tt-return     { background:#f3e8fd; color:#8e44ad; padding:3px 9px; border-radius:20px; font-size:12px; font-weight:600; }
            .tt-adjustment { background:#fff8e1; color:#f39c12; padding:3px 9px; border-radius:20px; font-size:12px; font-weight:600; }
            .tt-damage     { background:#fdecea; color:#e74c3c; padding:3px 9px; border-radius:20px; font-size:12px; font-weight:600; }
        </style>
    @endpush
    <x-slot name="header"></x-slot>

    <div class="data-table-area mg-b-15">
        <div class="container-fluid">
            <div class="row">

                <x-page-header title="Stock Transactions">
                    <a href="{{ route('inventory.transactions.create') }}" style="color:#333;"><i class="fa fa-plus"></i> New Transaction</a>
                    <a href="{{ route('inventory.index') }}" style="color:#333;"><i class="fa fa-tachometer"></i> Dashboard</a>
                </x-page-header>

                {{-- Filters --}}
                <div class="col-lg-12">
                    <form method="GET" action="{{ route('inventory.transactions.index') }}">
                        <div class="filter-card">
                            <div class="row">
                                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label>Item</label>
                                        <input type="text" name="item" class="form-control input-sm"
                                            placeholder="Search item..." value="{{ request('item') }}">
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label>From Date</label>
                                        <input type="text" name="from_date" class="form-control input-sm datepicker"
                                            placeholder="YYYY-MM-DD" value="{{ request('from_date') }}">
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label>To Date</label>
                                        <input type="text" name="to_date" class="form-control input-sm datepicker"
                                            placeholder="YYYY-MM-DD" value="{{ request('to_date') }}">
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label>Type</label>
                                        <select name="type" class="form-control input-sm">
                                            <option value="">All</option>
                                            @foreach(['purchase','issue','return','adjustment','damage'] as $t)
                                                <option value="{{ $t }}" {{ request('type') === $t ? 'selected' : '' }}>{{ ucfirst($t) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label>&nbsp;</label>
                                        <div style="display:flex; gap:6px;">
                                            <button type="submit" class="btn btn-primary btn-sm btn-block">
                                                <i class="fa fa-search"></i> Filter
                                            </button>
                                            <a href="{{ route('inventory.transactions.index') }}" class="btn btn-default btn-sm" title="Reset">
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
                                                <th>Date</th>
                                                <th>Item</th>
                                                <th>Type</th>
                                                <th>Quantity</th>
                                                <th>Reference</th>
                                                <th>Recorded By</th>
                                                <th>Notes</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $stockIn = ['purchase','return','adjustment']; @endphp
                                            @forelse($transactions as $i => $txn)
                                                <tr>
                                                    <td>{{ $transactions->firstItem() + $i }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($txn->created_at)->format('d M Y') }}</td>
                                                    <td><strong>{{ $txn->item?->name ?? 'N/A' }}</strong></td>
                                                    <td><span class="tt-{{ $txn->transaction_type }}">{{ ucfirst($txn->transaction_type) }}</span></td>
                                                    <td style="font-weight:700; color:{{ in_array($txn->transaction_type,$stockIn) ? '#27ae60' : '#e74c3c' }};">
                                                        {{ in_array($txn->transaction_type,$stockIn) ? '+' : '−' }}{{ $txn->quantity }}
                                                    </td>
                                                    <td>{{ $txn->reference_number ?? '—' }}</td>
                                                    <td>{{ $txn->user?->name ?? '—' }}</td>
                                                    <td>{{ $txn->notes ?? '—' }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="8" class="text-center text-muted" style="padding:40px;">
                                                        <i class="fa fa-exchange fa-3x" style="color:#ddd;"></i>
                                                        <br><br>No transactions found.
                                                        @if(request()->hasAny(['item','from_date','to_date','type']))
                                                            <br><a href="{{ route('inventory.transactions.index') }}">Clear filters</a>
                                                        @else
                                                            <br><a href="{{ route('inventory.transactions.create') }}">Record a transaction</a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                @if($transactions->hasPages())
                                    <div style="margin-top:15px;">{{ $transactions->links() }}</div>
                                @endif
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
    @endpush
</x-tenant-app-layout>
