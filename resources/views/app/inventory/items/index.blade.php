<x-tenant-app-layout>
    @push('css')
        <link rel="stylesheet" href="{{ asset('backend/css/data-table/bootstrap-table.css') }}">
        <style>
            .stock-badge { padding:3px 10px; border-radius:20px; font-size:12px; font-weight:600; }
            .stock-ok   { background:#e6f9ee; color:#27ae60; }
            .stock-low  { background:#fff8e1; color:#f39c12; }
            .stock-none { background:#fdecea; color:#e74c3c; }
        </style>
    @endpush
    <x-slot name="header"></x-slot>

    <div class="data-table-area mg-b-15">
        <div class="container-fluid">
            <div class="row">

                <x-page-header :title="request('filter') === 'low' ? 'Low Stock Items' : 'Inventory Items'">
                    <a href="{{ route('inventory.items.create') }}" style="color:#333;"><i class="fa fa-plus"></i> Add Item</a>
                    <a href="{{ route('inventory.transactions.create') }}" style="color:#333;"><i class="fa fa-exchange"></i> Stock Transaction</a>
                    <a href="{{ route('inventory.index') }}" style="color:#333;"><i class="fa fa-tachometer"></i> Dashboard</a>
                </x-page-header>

                @if(request('filter') === 'low')
                    <div class="col-lg-12">
                        <div class="alert alert-warning" style="margin-bottom:15px;">
                            <i class="fa fa-exclamation-triangle"></i>
                            Showing items at or below their minimum quantity. Use <strong>Record Purchase</strong> to restock.
                        </div>
                    </div>
                @endif

                <div class="col-lg-8 col-md-7 col-sm-12">
                    <div class="sparkline13-list">
                        <div class="sparkline13-graph">
                            <div class="datatable-dashv1-list custom-datatable-overright">
                                <table class="table hover-table timetable-datatable"
                                    data-toggle="table"
                                    data-pagination="true"
                                    data-search="true"
                                    data-show-columns="true">
                                    <thead>
                                        <tr>
                                            <th data-field="id"       data-sortable="true">#</th>
                                            <th data-field="name"     data-sortable="true">Item Name</th>
                                            <th data-field="category" data-sortable="true">Category</th>
                                            <th data-field="qty"      data-sortable="true">Quantity</th>
                                            <th data-field="min"      data-sortable="true">Min</th>
                                            <th data-field="unit">Unit</th>
                                            <th data-field="location">Location</th>
                                            <th data-field="status"   data-sortable="true">Status</th>
                                            <th data-field="actions">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($items as $i => $item)
                                            @php
                                                $out = $item->quantity <= 0;
                                                $low = !$out && $item->min_quantity && $item->quantity <= $item->min_quantity;
                                                $cls = $out ? 'stock-none' : ($low ? 'stock-low' : 'stock-ok');
                                            @endphp
                                            <tr>
                                                <td>{{ $i + 1 }}</td>
                                                <td><strong>{{ $item->name }}</strong></td>
                                                <td>{{ $item->category ?? '—' }}</td>
                                                <td>{{ $item->quantity }}</td>
                                                <td>{{ $item->min_quantity ?? '—' }}</td>
                                                <td>{{ $item->unit ? ucfirst($item->unit) : '—' }}</td>
                                                <td>{{ $item->location ?? '—' }}</td>
                                                <td>
                                                    <span class="stock-badge {{ $cls }}">
                                                        {{ $out ? 'Out of Stock' : ($low ? 'Low' : 'In Stock') }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <div style="display:flex; gap:4px;">
                                                        <a href="{{ route('inventory.items.show', $item) }}" class="btn btn-xs btn-success" title="View">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('inventory.items.edit', $item) }}" class="btn btn-xs btn-primary" title="Edit">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                        <a href="{{ route('inventory.transactions.create') }}?item_id={{ $item->id }}" class="btn btn-xs btn-info" title="Transaction">
                                                            <i class="fa fa-exchange"></i>
                                                        </a>
                                                        <form action="{{ route('inventory.items.destroy', $item) }}" method="POST">
                                                            @csrf @method('DELETE')
                                                            <button class="btn btn-xs btn-danger" title="Delete"
                                                                onclick="return confirm('Delete this item?')">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="9" class="text-center text-muted" style="padding:40px;">
                                                    <i class="fa fa-cubes fa-3x" style="color:#ddd;"></i>
                                                    <br><br>No inventory items yet.
                                                    <br><a href="{{ route('inventory.items.create') }}">Add the first item</a>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-5 col-sm-12">
                    <x-inventory-guide screen="items-index" :low-filter="request('filter') === 'low'" />
                </div>

            </div>
        </div>
    </div>

    @push('js')
        <script src="{{ asset('backend/js/data-table/bootstrap-table.js') }}"></script>
        <script src="{{ asset('backend/js/data-table/data-table-active.js') }}"></script>
    @endpush
</x-tenant-app-layout>
