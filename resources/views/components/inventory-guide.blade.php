@props([
    'screen' => 'dashboard',
    'type' => null,
    'item' => null,
    'lowFilter' => false,
])

@php
    $transactionHints = [
        'purchase'   => 'Record new stock received from a supplier. Quantity is added to current stock.',
        'issue'      => 'Issue items to a department, classroom, or staff member. Quantity is subtracted.',
        'return'     => 'Return previously issued items back to the store. Quantity is added.',
        'adjustment' => 'Correct stock after a physical count. Quantity is added.',
        'damage'     => 'Remove damaged, expired, or lost units. Quantity is subtracted.',
    ];
@endphp

{{-- How-to --}}
<div class="white-box" style="margin-bottom: 20px;">
    <h5 style="margin-top:0; color:#3c8dbc;">
        <i class="fa fa-lightbulb-o"></i>
        @switch($screen)
            @case('dashboard') How to use Inventory Dashboard @break
            @case('items-index') How to manage items @break
            @case('items-create') How to add an item @break
            @case('items-edit') How to edit an item @break
            @case('items-show') Understanding item details @break
            @case('transactions-create') How to record a transaction @break
            @case('transactions-index') How to use the transaction log @break
            @default Inventory guide
        @endswitch
    </h5>
    <ol style="padding-left: 18px; line-height: 1.9; color: #555; font-size: 13px; margin-bottom: 0;">
        @if($screen === 'dashboard')
            <li>Review the <strong>summary cards</strong> — total items, stock units, low stock, and out-of-stock counts.</li>
            <li>Use <strong>Quick Actions</strong> to record a purchase, issue stock, add a new item, or view low-stock alerts.</li>
            <li>Check the <strong>Low Stock Alerts</strong> table and reorder items that are at or below minimum quantity.</li>
            <li>Monitor <strong>Recent Transactions</strong> to see the latest stock movements.</li>
            <li>Use the header menu for full item lists and the complete transaction log.</li>
        @elseif($screen === 'items-index')
            @if($lowFilter)
                <li>This list shows only items at or below their <strong>minimum quantity</strong> threshold.</li>
                <li>Orange badge = <strong>Low Stock</strong>; red badge = <strong>Out of Stock</strong>.</li>
                <li>Click an item name to view details and transaction history.</li>
                <li>Use the <strong>Transaction</strong> button (<i class="fa fa-exchange"></i>) to record a <strong>Purchase</strong> and restock.</li>
                <li>Update <strong>Minimum Quantity</strong> on an item if the alert threshold needs adjusting.</li>
            @else
                <li>Search and sort the table to find items by name, category, or stock level.</li>
                <li>Status badges: green = In Stock, orange = Low, red = Out of Stock.</li>
                <li>Click <strong>View</strong> for details, <strong>Edit</strong> to update item info, or <strong>Transaction</strong> to move stock.</li>
                <li>Add new products with <strong>Add Item</strong> in the header.</li>
                <li>Visit the dashboard and use <strong>View Low Stock</strong> for reorder alerts.</li>
            @endif
        @elseif($screen === 'items-create')
            <li>Enter a clear <strong>Item Name</strong> and choose a <strong>Category</strong> for easy filtering.</li>
            <li>Set <strong>Quantity</strong> to the current stock on hand when first adding the item.</li>
            <li>Set <strong>Minimum Quantity</strong> — you will get low-stock alerts when stock falls to this level.</li>
            <li>Choose the correct <strong>Unit</strong> (piece, box, ream, etc.) and storage <strong>Location</strong>.</li>
            <li>After saving, use <strong>Stock Transactions</strong> for all future stock in/out movements.</li>
        @elseif($screen === 'items-edit')
            <li>Update name, category, unit, location, or description as needed.</li>
            <li><strong>Minimum Quantity</strong> controls when low-stock alerts appear on the dashboard.</li>
            <li>For day-to-day stock changes, use <strong>Stock Transactions</strong> instead of editing quantity directly — this keeps an audit trail.</li>
            <li>Only adjust quantity here for one-time corrections when no transaction record is needed.</li>
        @elseif($screen === 'items-show')
            <li>The left panel shows current stock, minimum level, and status for this item.</li>
            <li>The <strong>Transaction History</strong> lists every stock movement with date, type, and quantity.</li>
            <li>Green <strong>+</strong> = stock in (purchase, return, adjustment); red <strong>−</strong> = stock out (issue, damage).</li>
            <li>Use <strong>New Transaction</strong> to record purchases, issues, returns, or damage for this item.</li>
            <li>Click <strong>Edit</strong> to update item details or minimum quantity threshold.</li>
        @elseif($screen === 'transactions-create')
            <li>Select the <strong>Item</strong> — current stock is shown automatically.</li>
            <li>Choose the correct <strong>Transaction Type</strong> (see transaction types card below).</li>
            <li>Enter <strong>Quantity</strong> — must be at least 1. Stock-out types cannot exceed available stock.</li>
            <li>Add a <strong>Reference Number</strong> (invoice, PO, voucher) for audit purposes.</li>
            <li>Click <strong>Record Transaction</strong> — stock updates immediately.</li>
            @if($type && isset($transactionHints[$type]))
                <li><strong>This page:</strong> {{ $transactionHints[$type] }}</li>
            @endif
            @if($item)
                <li><strong>Pre-selected item:</strong> {{ $item->name }} (current stock: {{ $item->quantity }} {{ $item->unit }})</li>
            @endif
        @elseif($screen === 'transactions-index')
            <li>Filter by <strong>item name</strong>, <strong>date range</strong>, or <strong>transaction type</strong>.</li>
            <li>Green quantities (+) increase stock; red quantities (−) decrease stock.</li>
            <li>Use this log to audit purchases, issues, returns, adjustments, and damage reports.</li>
            <li>Click <strong>New Transaction</strong> to record stock in or stock out.</li>
            <li>Click <strong>Reset</strong> (<i class="fa fa-refresh"></i>) to clear all filters.</li>
        @endif
    </ol>
</div>

{{-- Transaction types (for transaction screens) --}}
@if(in_array($screen, ['transactions-create', 'transactions-index', 'dashboard']))
    <div class="white-box" style="margin-bottom: 20px;">
        <h5 style="margin-top:0; color:#3c8dbc;">
            <i class="fa fa-exchange"></i> Transaction types
        </h5>
        <table class="table table-condensed table-bordered" style="font-size: 12px; margin-bottom: 0;">
            <tbody>
                <tr><th style="width:38%; background:#f5f5f5;">Purchase</th><td>Stock <strong>in</strong> — new goods received</td></tr>
                <tr><th style="background:#f5f5f5;">Issue</th><td>Stock <strong>out</strong> — given to class/staff</td></tr>
                <tr><th style="background:#f5f5f5;">Return</th><td>Stock <strong>in</strong> — unused items returned</td></tr>
                <tr><th style="background:#f5f5f5;">Adjustment</th><td>Stock <strong>in</strong> — count correction</td></tr>
                <tr><th style="background:#f5f5f5;">Damage / Loss</th><td>Stock <strong>out</strong> — broken or lost items</td></tr>
            </tbody>
        </table>
    </div>
@endif

{{-- Example --}}
@if(in_array($screen, ['items-create', 'items-edit', 'transactions-create', 'dashboard']))
    <div class="white-box" style="margin-bottom: 20px;">
        <h5 style="margin-top:0; color:#3c8dbc;">
            <i class="fa fa-file-text-o"></i> Example
        </h5>
        <table class="table table-condensed table-bordered" style="font-size: 12px; margin-bottom: 0;">
            <tbody>
                @if($screen === 'transactions-create')
                    @php
                        $exampleType = $type ?: 'purchase';
                        $examples = [
                            'purchase'   => ['Item' => 'A4 Paper Ream', 'Type' => 'Purchase', 'Qty' => '50', 'Ref' => 'INV-2026-0142'],
                            'issue'      => ['Item' => 'Whiteboard Marker', 'Type' => 'Issue', 'Qty' => '10', 'Ref' => 'Issue to Class 8'],
                            'return'     => ['Item' => 'Lab Beaker Set', 'Type' => 'Return', 'Qty' => '5', 'Ref' => 'Returned from Lab'],
                            'adjustment' => ['Item' => 'Desk Chair', 'Type' => 'Adjustment', 'Qty' => '2', 'Ref' => 'Physical count'],
                            'damage'     => ['Item' => 'Projector Bulb', 'Type' => 'Damage', 'Qty' => '1', 'Ref' => 'Broken unit'],
                        ];
                        $ex = $examples[$exampleType] ?? $examples['purchase'];
                    @endphp
                    @foreach($ex as $label => $val)
                        <tr><th style="width:42%; background:#f5f5f5;">{{ $label }}</th><td>{{ $val }}</td></tr>
                    @endforeach
                @else
                    <tr><th style="width:42%; background:#f5f5f5;">Item</th><td>Whiteboard Marker (Blue)</td></tr>
                    <tr><th style="background:#f5f5f5;">Category</th><td>Stationery</td></tr>
                    <tr><th style="background:#f5f5f5;">Quantity</th><td>120 piece</td></tr>
                    <tr><th style="background:#f5f5f5;">Minimum</th><td>20 piece</td></tr>
                    <tr><th style="background:#f5f5f5;">Location</th><td>Store Room A</td></tr>
                @endif
            </tbody>
        </table>
    </div>
@endif

{{-- Notes --}}
<div class="white-box">
    <h5 style="margin-top:0; color:#e08e0b;">
        <i class="fa fa-exclamation-triangle"></i> Things to keep in mind
    </h5>
    <ul style="padding-left: 18px; line-height: 1.9; color: #555; font-size: 13px; margin-bottom: 0;">
        @if($screen === 'dashboard' || $screen === 'items-index')
            <li>Low-stock alerts trigger when quantity is <strong>at or below</strong> the minimum you set on each item.</li>
            <li>Always record stock movements as <strong>transactions</strong> — do not only change quantity manually.</li>
        @endif
        @if($screen === 'items-create' || $screen === 'items-edit')
            <li>Item names should be unique and descriptive enough to tell products apart.</li>
            <li>Deleting an item removes it permanently — consider setting quantity to 0 instead if you need history.</li>
        @endif
        @if($screen === 'transactions-create')
            <li>You cannot issue or damage more units than are currently in stock.</li>
            <li>Reference numbers help match transactions to invoices or internal vouchers.</li>
        @endif
        @if($screen === 'items-show')
            <li>Transaction history cannot be edited — record an adjustment if a past entry was wrong.</li>
        @endif
        @if($lowFilter)
            <li>Restock low items with a <strong>Purchase</strong> transaction and keep the reference invoice number.</li>
        @endif
        <li>Stock changes apply immediately and appear on the dashboard and transaction log.</li>
    </ul>
</div>
