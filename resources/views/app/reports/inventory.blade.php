<x-tenant-app-layout>
    @push('css')
        <link rel="stylesheet" href="{{ asset('backend/css/data-table/bootstrap-table.css') }}">
        <style>
            .filter-card { background:#fff; border:1px solid #e0e0e0; border-radius:6px; padding:16px 20px; margin-bottom:20px; }
            .filter-card label { font-weight:600; font-size:13px; color:#555; }
            .rep-stat { background:#fff; border:1px solid #e0e0e0; border-radius:6px; padding:16px 20px; margin-bottom:20px; text-align:center; }
            .rep-stat h2 { margin:4px 0; font-size:24px; font-weight:700; }
            .rep-stat p  { margin:0; font-size:12px; color:#888; }
        </style>
    @endpush
    <x-slot name="header"></x-slot>

    <div class="data-table-area mg-b-15">
        <div class="container-fluid">
            <div class="row">

                <x-page-header title="Inventory Report">
                    <a href="javascript:window.print()" style="color:#333;"><i class="fa fa-print"></i> Print</a>
                    <a href="#" style="color:#333;"><i class="fa fa-file-excel-o"></i> Export Excel</a>
                    <a href="{{ route('reports.index') }}" style="color:#333;"><i class="fa fa-th-large"></i> All Reports</a>
                </x-page-header>

                <div class="col-lg-12">
                    <form method="GET" action="{{ route('reports.inventory') }}">
                        <div class="filter-card">
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label>Category</label>
                                        <select name="category" class="form-control input-sm">
                                            <option value="">All Categories</option>
                                            @foreach(['Stationery','Furniture','Electronics','Lab Equipment','Sports Equipment','Cleaning Supplies','IT Equipment','Medical','Other'] as $cat)
                                                <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label>Stock Level</label>
                                        <select name="stock" class="form-control input-sm">
                                            <option value="">All</option>
                                            <option value="low" {{ request('stock') === 'low' ? 'selected' : '' }}>Low Stock</option>
                                            <option value="out" {{ request('stock') === 'out' ? 'selected' : '' }}>Out of Stock</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label>&nbsp;</label>
                                        <div style="display:flex; gap:6px;">
                                            <button type="submit" class="btn btn-primary btn-sm btn-block"><i class="fa fa-search"></i> Generate</button>
                                            <a href="{{ route('reports.inventory') }}" class="btn btn-default btn-sm" title="Reset"><i class="fa fa-refresh"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12"><div class="rep-stat" style="border-top:3px solid #3498db;"><p>Total Items</p><h2>{{ number_format($summary['items']) }}</h2></div></div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12"><div class="rep-stat" style="border-top:3px solid #27ae60;"><p>Total Stock</p><h2>{{ number_format($summary['stock']) }}</h2></div></div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12"><div class="rep-stat" style="border-top:3px solid #f39c12;"><p>Low Stock</p><h2>{{ number_format($summary['low']) }}</h2></div></div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12"><div class="rep-stat" style="border-top:3px solid #e74c3c;"><p>Out of Stock</p><h2>{{ number_format($summary['out']) }}</h2></div></div>

                <div class="col-lg-12">
                    <div class="sparkline13-list">
                        <div class="sparkline13-hd"><div class="main-sparkline13-hd"><h1>Stock by Category</h1></div></div>
                        <div class="sparkline13-graph">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr><th>Category</th><th>Items</th><th>Total Stock</th><th>Low Stock</th><th>Out of Stock</th></tr>
                                    </thead>
                                    <tbody>
                                        @forelse($byCategory as $row)
                                            <tr>
                                                <td><strong>{{ $row->category ?: 'Uncategorized' }}</strong></td>
                                                <td>{{ $row->items }}</td>
                                                <td>{{ number_format($row->stock) }}</td>
                                                <td>{{ $row->low > 0 ? '' : '' }}<span style="color:{{ $row->low > 0 ? '#f39c12' : '#888' }};">{{ $row->low }}</span></td>
                                                <td><span style="color:{{ $row->out > 0 ? '#e74c3c' : '#888' }};">{{ $row->out }}</span></td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="5" class="text-center text-muted" style="padding:30px;">
                                                <i class="fa fa-cubes fa-2x" style="color:#ddd;"></i><br>No items match the selected filters.
                                            </td></tr>
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
