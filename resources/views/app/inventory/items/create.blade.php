<x-tenant-app-layout>
    <x-slot name="header"></x-slot>

    <div class="container-fluid">
        <div class="row">

            <x-page-header title="Add Inventory Item" :back-route="route('inventory.items.index')" />

            <div class="col-lg-8 col-md-7 col-sm-12 col-xs-12">
                <div class="sparkline12-list">
                    <div class="sparkline12-graph">
                        <div class="basic-login-form-ad">
                            <form action="{{ route('inventory.items.store') }}" method="POST">
                                @csrf

                                <div class="row">
                                    <div class="col-lg-8">
                                        <div class="form-group">
                                            <label>Item Name <span class="text-danger">*</span></label>
                                            <input type="text" name="name" class="form-control"
                                                placeholder="e.g. Whiteboard Marker" value="{{ old('name') }}" required>
                                            @error('name')<small class="text-danger">{{ $message }}</small>@enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Category</label>
                                            <select name="category" class="form-control">
                                                <option value="">-- Select Category --</option>
                                                @foreach(['Stationery','Furniture','Electronics','Lab Equipment','Sports Equipment','Cleaning Supplies','IT Equipment','Books & Media','Uniform','Medical','Other'] as $cat)
                                                    <option value="{{ $cat }}" {{ old('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label>Quantity <span class="text-danger">*</span></label>
                                            <input type="number" name="quantity" class="form-control"
                                                placeholder="0" min="0" value="{{ old('quantity', 0) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label>Minimum Quantity</label>
                                            <input type="number" name="min_quantity" class="form-control"
                                                placeholder="0" min="0" value="{{ old('min_quantity', 0) }}">
                                            <small class="text-muted">Low-stock alert threshold</small>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label>Unit</label>
                                            <select name="unit" class="form-control">
                                                <option value="">-- Unit --</option>
                                                @foreach(['piece','box','pack','set','dozen','kg','litre','metre','ream','bottle'] as $u)
                                                    <option value="{{ $u }}" {{ old('unit') === $u ? 'selected' : '' }}>{{ ucfirst($u) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label>Location</label>
                                            <input type="text" name="location" class="form-control"
                                                placeholder="e.g. Store Room A" value="{{ old('location') }}">
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Description</label>
                                            <textarea name="description" class="form-control" rows="2"
                                                placeholder="Optional notes">{{ old('description') }}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-lg-12" style="margin-top:10px;">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-save"></i> Save Item
                                        </button>
                                        <a href="{{ route('inventory.items.index') }}" class="btn btn-default" style="margin-left:8px;">
                                            Cancel
                                        </a>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-5 col-sm-12 col-xs-12">
                <x-inventory-guide screen="items-create" />
            </div>

        </div>
    </div>
</x-tenant-app-layout>
