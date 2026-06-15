<x-tenant-app-layout>
    @push('css')
        <style>
            .info-box { background:#fff; border:1px solid #e0e0e0; border-radius:6px; padding:18px 20px; margin-bottom:20px; }
            .info-box h4 { margin:0 0 12px; font-size:15px; font-weight:700; border-bottom:1px solid #f0f0f0; padding-bottom:8px; }
            .info-row { display:flex; justify-content:space-between; padding:6px 0; border-bottom:1px solid #f8f8f8; font-size:13px; }
            .info-row:last-child { border-bottom:none; }
            .info-row span:first-child { color:#888; }
            .info-row span:last-child  { font-weight:600; }
        </style>
    @endpush
    <x-slot name="header"></x-slot>

    <div class="data-table-area mg-b-15">
        <div class="container-fluid">
            <div class="row">

                <x-page-header title="{{ $item->name }}">
                    <a href="{{ route('inventory.transactions.create') }}?item_id={{ $item->id }}" style="color:#333;"><i class="fa fa-exchange"></i> New Transaction</a>
                    <a href="{{ route('inventory.items.edit', $item) }}" style="color:#333;"><i class="fa fa-edit"></i> Edit Item</a>
                </x-page-header>

                <div class="col-lg-4 col-md-5 col-xs-12">
                    <div class="info-box">
                        <h4><i class="fa fa-cube"></i> Item Details</h4>
                        <div class="info-row"><span>Name</span><span>{{ $item->name }}</span></div>
                        <div class="info-row"><span>Category</span><span>{{ $item->category ?? '—' }}</span></div>
                        <div class="info-row"><span>Unit</span><span>{{ $item->unit ? ucfirst($item->unit) : '—' }}</span></div>
                        <div class="info-row"><span>Location</span><span>{{ $item->location ?? '—' }}</span></div>
                        @php
                            $out = $item->quantity <= 0;
                            $low = !$out && $item->min_quantity && $item->quantity <= $item->min_quantity;
                            $color = $out ? '#e74c3c' : ($low ? '#f39c12' : '#27ae60');
                            $label = $out ? 'Out of Stock' : ($low ? 'Low Stock' : 'In Stock');
                        @endphp
                        <div class="info-row">
                            <span>Current Stock</span>
                            <span style="color:{{ $color }}; font-weight:700;">{{ $item->quantity }} {{ $item->unit }}</span>
                        </div>
                        <div class="info-row"><span>Minimum Qty</span><span>{{ $item->min_quantity ?? '—' }}</span></div>
                        <div class="info-row">
                            <span>Status</span>
                            <span><span class="label" style="background:{{ $color }};color:#fff;">{{ $label }}</span></span>
                        </div>
                        @if($item->description)
                            <div style="margin-top:10px; font-size:13px; color:#666;">{{ $item->description }}</div>
                        @endif
                    </div>

                    <div style="display:flex; gap:8px;">
                        <a href="{{ route('inventory.items.edit', $item) }}" class="btn btn-primary btn-sm btn-block">
                            <i class="fa fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('inventory.items.destroy', $item) }}" method="POST" style="flex:1;">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm btn-block"
                                onclick="return confirm('Delete this item?')">
                                <i class="fa fa-trash"></i> Delete
                            </button>
                        </form>
                    </div>

                    <div style="margin-top:20px;">
                        <x-inventory-guide screen="items-show" />
                    </div>
                </div>

                {{-- Transaction history --}}
                <div class="col-lg-8 col-md-7 col-xs-12">
                    <div class="sparkline13-list">
                        <div class="sparkline13-hd">
                            <div class="main-sparkline13-hd" style="display:flex;justify-content:space-between;align-items:center;">
                                <h1>Transaction History</h1>
                                <a href="{{ route('inventory.transactions.create') }}?item_id={{ $item->id }}" class="btn btn-primary btn-sm">
                                    <i class="fa fa-exchange"></i> New Transaction
                                </a>
                            </div>
                        </div>
                        <div class="sparkline13-graph">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Date</th>
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
                                        @forelse($item->transactions as $i => $txn)
                                            <tr>
                                                <td>{{ $i + 1 }}</td>
                                                <td>{{ \Carbon\Carbon::parse($txn->created_at)->format('d M Y') }}</td>
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
                                                    <i class="fa fa-history fa-2x" style="color:#ddd;"></i>
                                                    <br>No transactions for this item.
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
