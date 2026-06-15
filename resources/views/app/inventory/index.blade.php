<x-tenant-app-layout>
    @push('css')
        <link rel="stylesheet" href="{{ asset('backend/css/data-table/bootstrap-table.css') }}">
        <style>
            .inv-stat { background:#fff; border:1px solid #e0e0e0; border-radius:6px; padding:18px 20px; margin-bottom:20px; }
            .inv-stat h2 { margin:4px 0; font-size:26px; font-weight:700; }
            .inv-stat p  { margin:0; font-size:13px; color:#777; }
            .inv-stat.blue   { border-top:3px solid #3498db; }
            .inv-stat.green  { border-top:3px solid #27ae60; }
            .inv-stat.orange { border-top:3px solid #f39c12; }
            .inv-stat.red    { border-top:3px solid #e74c3c; }
            .quick-link { display:block; padding:12px 16px; border-radius:5px; margin-bottom:10px; color:#fff; font-weight:600; text-decoration:none; }
            .quick-link:hover { opacity:.88; color:#fff; }
        </style>
    @endpush
    <x-slot name="header"></x-slot>

    <div class="data-table-area mg-b-15">
        <div class="container-fluid">
            <div class="row">

                <x-page-header title="Inventory Management">
                    <a href="{{ route('inventory.items.create') }}" style="color:#333;"><i class="fa fa-plus"></i> Add Item</a>
                    <a href="{{ route('inventory.transactions.create') }}" style="color:#333;"><i class="fa fa-exchange"></i> Stock Transaction</a>
                    <a href="{{ route('inventory.items.index') }}" style="color:#333;"><i class="fa fa-cubes"></i> All Items</a>
                    <a href="{{ route('inventory.transactions.index') }}" style="color:#333;"><i class="fa fa-history"></i> Transaction Log</a>
                </x-page-header>

                {{-- Summary Cards --}}
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <div class="inv-stat blue">
                        <p><i class="fa fa-cubes"></i> Total Items</p>
                        <h2>{{ number_format($totalItems) }}</h2>
                        <p>Distinct products</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <div class="inv-stat green">
                        <p><i class="fa fa-archive"></i> Total Stock</p>
                        <h2>{{ number_format($totalStock) }}</h2>
                        <p>Units in store</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <div class="inv-stat orange">
                        <p><i class="fa fa-exclamation-triangle"></i> Low Stock</p>
                        <h2>{{ number_format($lowStock) }}</h2>
                        <p>At / below minimum</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <div class="inv-stat red">
                        <p><i class="fa fa-times-circle"></i> Out of Stock</p>
                        <h2>{{ number_format($outOfStock) }}</h2>
                        <p>Zero units</p>
                    </div>
                </div>

                {{-- Quick Actions + Guide --}}
                <div class="col-lg-4 col-md-12 col-xs-12">
                    <div class="white-box">
                        <h3 class="box-title">Quick Actions</h3>
                        <a href="{{ route('inventory.transactions.create') }}?type=purchase" class="quick-link" style="background:#27ae60;">
                            <i class="fa fa-shopping-cart"></i> Record Purchase
                        </a>
                        <a href="{{ route('inventory.transactions.create') }}?type=issue" class="quick-link" style="background:#3498db;">
                            <i class="fa fa-share"></i> Issue Stock
                        </a>
                        <a href="{{ route('inventory.items.create') }}" class="quick-link" style="background:#8e44ad;">
                            <i class="fa fa-plus"></i> Add New Item
                        </a>
                        <a href="{{ route('inventory.items.index') }}?filter=low" class="quick-link" style="background:#f39c12;">
                            <i class="fa fa-exclamation-triangle"></i> View Low Stock
                        </a>
                    </div>
                    <x-inventory-guide screen="dashboard" />
                </div>

                {{-- Low Stock Alerts --}}
                <div class="col-lg-8 col-md-12 col-xs-12">
                    <div class="sparkline13-list">
                        <div class="sparkline13-hd">
                            <div class="main-sparkline13-hd">
                                <h1>Low Stock Alerts</h1>
                            </div>
                        </div>
                        <div class="sparkline13-graph">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Item</th>
                                            <th>Category</th>
                                            <th>Current</th>
                                            <th>Minimum</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($lowStockItems as $li)
                                            @php $out = $li->quantity <= 0; @endphp
                                            <tr>
                                                <td><a href="{{ route('inventory.items.show', $li) }}">{{ $li->name }}</a></td>
                                                <td>{{ $li->category ?? '—' }}</td>
                                                <td style="color:{{ $out ? '#e74c3c' : '#f39c12' }}; font-weight:700;">{{ $li->quantity }} {{ $li->unit }}</td>
                                                <td>{{ $li->min_quantity }}</td>
                                                <td>
                                                    @if($out)
                                                        <span class="label label-danger">Out of Stock</span>
                                                    @else
                                                        <span class="label label-warning">Low</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center text-muted" style="padding:30px;">
                                                    <i class="fa fa-check-circle fa-2x" style="color:#ddd;"></i>
                                                    <br>No low-stock items.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Recent Transactions --}}
                <div class="col-lg-12" style="margin-top:10px;">
                    <div class="sparkline13-list">
                        <div class="sparkline13-hd">
                            <div class="main-sparkline13-hd">
                                <h1>Recent Stock Transactions</h1>
                            </div>
                        </div>
                        <div class="sparkline13-graph">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Item</th>
                                            <th>Type</th>
                                            <th>Quantity</th>
                                            <th>Reference</th>
                                            <th>By</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $typeLabel = ['purchase'=>'success','return'=>'primary','issue'=>'info','adjustment'=>'warning','damage'=>'danger'];
                                            $stockIn   = ['purchase','return','adjustment'];
                                        @endphp
                                        @forelse($recentTransactions as $txn)
                                            <tr>
                                                <td>{{ \Carbon\Carbon::parse($txn->created_at)->format('d M Y') }}</td>
                                                <td>{{ $txn->item?->name ?? 'N/A' }}</td>
                                                <td><span class="label label-{{ $typeLabel[$txn->transaction_type] ?? 'default' }}">{{ ucfirst($txn->transaction_type) }}</span></td>
                                                <td style="font-weight:700; color:{{ in_array($txn->transaction_type,$stockIn) ? '#27ae60' : '#e74c3c' }};">
                                                    {{ in_array($txn->transaction_type,$stockIn) ? '+' : '−' }}{{ $txn->quantity }}
                                                </td>
                                                <td>{{ $txn->reference_number ?? '—' }}</td>
                                                <td>{{ $txn->user?->name ?? '—' }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center text-muted" style="padding:30px;">
                                                    <i class="fa fa-exchange fa-2x" style="color:#ddd;"></i>
                                                    <br>No transactions recorded yet.
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
