<x-tenant-app-layout>
    <x-slot name="header"></x-slot>

    <div class="container-fluid">
        <div class="row">

            <x-page-header title="Create Fee Structure" :back-route="route('fees.structures.index')" />

            <div class="col-lg-8 col-md-10 col-sm-12 col-xs-12">
                <div class="sparkline12-list">
                    <div class="sparkline12-graph">
                        <div class="basic-login-form-ad">
                            <form action="{{ route('fees.structures.store') }}" method="POST">
                                @csrf

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Structure Name <span class="text-danger">*</span></label>
                                            <input type="text" name="name" class="form-control"
                                                placeholder="e.g. Monthly Tuition - Class 5"
                                                value="{{ old('name') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Fee Category <span class="text-danger">*</span></label>
                                            <select name="category_id" class="form-control" required>
                                                <option value="">-- Select Category --</option>
                                                @foreach($categories as $cat)
                                                    <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                                        {{ $cat->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Class</label>
                                            <select name="class_id" class="form-control">
                                                <option value="">All Classes</option>
                                                @foreach($classes as $class)
                                                    <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                                        {{ $class->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Amount (PKR) <span class="text-danger">*</span></label>
                                            <input type="number" name="amount" class="form-control"
                                                placeholder="0.00" step="0.01" min="0"
                                                value="{{ old('amount') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Frequency</label>
                                            <select name="frequency" class="form-control">
                                                <option value="">-- Select --</option>
                                                <option value="one_time"   {{ old('frequency') === 'one_time'   ? 'selected' : '' }}>One Time</option>
                                                <option value="monthly"    {{ old('frequency') === 'monthly'    ? 'selected' : '' }}>Monthly</option>
                                                <option value="quarterly"  {{ old('frequency') === 'quarterly'  ? 'selected' : '' }}>Quarterly</option>
                                                <option value="yearly"     {{ old('frequency') === 'yearly'     ? 'selected' : '' }}>Yearly</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Due Date</label>
                                            <input type="date" name="due_date" class="form-control"
                                                value="{{ old('due_date') }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-12" style="margin-top:10px;">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-save"></i> Save Structure
                                        </button>
                                        <a href="{{ route('fees.structures.index') }}" class="btn btn-default" style="margin-left:8px;">
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
</x-tenant-app-layout>
