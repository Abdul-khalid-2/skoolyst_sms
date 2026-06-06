<x-tenant-app-layout>
    <x-slot name="header"></x-slot>

    <div class="container-fluid">
        <div class="row">

            <x-page-header title="Record Stock Transaction" :back-route="route('inventory.transactions.index')" />

            <div class="col-lg-8 col-md-10 col-sm-12 col-xs-12">
                <div class="sparkline12-list">
                    <div class="sparkline12-graph">
                        <div class="basic-login-form-ad">
                            <form action="{{ route('inventory.transactions.store') }}" method="POST">
                                @csrf

                                <div class="row">
                                    <div class="col-lg-8">
                                        <div class="form-group">
                                            <label>Item <span class="text-danger">*</span></label>
                                            <select name="item_id" id="txn_item" class="form-control" required>
                                                <option value="">-- Select Item --</option>
                                                @foreach($items as $it)
                                                    <option value="{{ $it->id }}"
                                                        data-stock="{{ $it->quantity }}" data-unit="{{ $it->unit }}"
                                                        {{ (request('item_id') == $it->id || old('item_id') == $it->id) ? 'selected' : '' }}>
                                                        {{ $it->name }} ({{ $it->quantity }} {{ $it->unit }})
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('item_id')<small class="text-danger">{{ $message }}</small>@enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Current Stock</label>
                                            <input type="text" id="txn_stock" class="form-control" readonly
                                                style="background:#f8f8f8; font-weight:700;" placeholder="—">
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Transaction Type <span class="text-danger">*</span></label>
                                            <select name="transaction_type" id="txn_type" class="form-control" required>
                                                <option value="">-- Select Type --</option>
                                                @php $sel = request('type', old('transaction_type')); @endphp
                                                <option value="purchase"   {{ $sel === 'purchase'   ? 'selected' : '' }}>Purchase (Stock In)</option>
                                                <option value="issue"      {{ $sel === 'issue'      ? 'selected' : '' }}>Issue (Stock Out)</option>
                                                <option value="return"     {{ $sel === 'return'     ? 'selected' : '' }}>Return (Stock In)</option>
                                                <option value="adjustment" {{ $sel === 'adjustment' ? 'selected' : '' }}>Adjustment</option>
                                                <option value="damage"     {{ $sel === 'damage'     ? 'selected' : '' }}>Damage / Loss (Stock Out)</option>
                                            </select>
                                            <small id="txn_hint" class="text-muted"></small>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Quantity <span class="text-danger">*</span></label>
                                            <input type="number" name="quantity" class="form-control"
                                                placeholder="0" min="1" value="{{ old('quantity') }}" required>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Reference Number</label>
                                            <input type="text" name="reference_number" class="form-control"
                                                placeholder="Invoice / PO / Voucher no" value="{{ old('reference_number') }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Notes</label>
                                            <textarea name="notes" class="form-control" rows="2"
                                                placeholder="Optional notes">{{ old('notes') }}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-lg-12" style="margin-top:10px;">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-save"></i> Record Transaction
                                        </button>
                                        <a href="{{ route('inventory.transactions.index') }}" class="btn btn-default" style="margin-left:8px;">
                                            Cancel
                                        </a>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @push('js')
        <script>
        $(document).ready(function () {
            function showStock() {
                var opt = $('#txn_item').find(':selected');
                var stock = opt.data('stock');
                var unit  = opt.data('unit') || '';
                $('#txn_stock').val(stock !== undefined && stock !== '' ? stock + ' ' + unit : '');
            }
            $('#txn_item').on('change', showStock).trigger('change');

            var hints = {
                purchase:   'Adds to current stock.',
                issue:      'Subtracts from current stock.',
                return:     'Adds returned units back to stock.',
                adjustment: 'Adds units as a stock-in correction.',
                damage:     'Subtracts damaged / lost units.'
            };
            $('#txn_type').on('change', function () {
                $('#txn_hint').text(hints[$(this).val()] || '');
            }).trigger('change');
        });
        </script>
    @endpush
</x-tenant-app-layout>
