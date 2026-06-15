<x-tenant-app-layout>
    <x-slot name="header"></x-slot>

    <div class="container-fluid">
        <div class="row">

            <x-page-header title="Add Holiday" :back-route="route('holidays.index')" />

            <div class="col-lg-8 col-md-10 col-sm-12 col-xs-12">
                <div class="sparkline12-list">
                    <div class="sparkline12-graph">
                        <div class="basic-login-form-ad">
                            <form action="{{ route('holidays.store') }}" method="POST">
                                @csrf

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Holiday Title <span class="text-danger">*</span></label>
                                            <input type="text" name="title" class="form-control"
                                                placeholder="e.g. Eid-ul-Fitr, Summer Vacation" value="{{ old('title') }}" required>
                                            @error('title')<small class="text-danger">{{ $message }}</small>@enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Start Date <span class="text-danger">*</span></label>
                                            <input type="date" name="start_date" class="form-control"
                                                value="{{ old('start_date') }}" required>
                                            @error('start_date')<small class="text-danger">{{ $message }}</small>@enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>End Date <span class="text-danger">*</span></label>
                                            <input type="date" name="end_date" class="form-control"
                                                value="{{ old('end_date') }}" required>
                                            @error('end_date')<small class="text-danger">{{ $message }}</small>@enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Recurring?</label>
                                            <div style="padding-top:8px;">
                                                <label style="font-weight:normal;">
                                                    <input type="checkbox" name="is_recurring" id="is_recurring" value="1"
                                                        {{ old('is_recurring') ? 'checked' : '' }}>
                                                    This holiday repeats
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Recurring Pattern</label>
                                            <select name="recurring_pattern" id="recurring_pattern" class="form-control" disabled>
                                                <option value="">-- Select Pattern --</option>
                                                <option value="yearly"  {{ old('recurring_pattern') === 'yearly'  ? 'selected' : '' }}>Yearly</option>
                                                <option value="monthly" {{ old('recurring_pattern') === 'monthly' ? 'selected' : '' }}>Monthly</option>
                                                <option value="weekly"  {{ old('recurring_pattern') === 'weekly'  ? 'selected' : '' }}>Weekly</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Description</label>
                                            <textarea name="description" class="form-control" rows="3"
                                                placeholder="Optional details">{{ old('description') }}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-lg-12" style="margin-top:10px;">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-save"></i> Save Holiday
                                        </button>
                                        <a href="{{ route('holidays.index') }}" class="btn btn-default" style="margin-left:8px;">
                                            Cancel
                                        </a>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                <x-holidays-guide screen="create" />
            </div>

        </div>
    </div>

    @push('js')
        <script>
        $(document).ready(function () {
            function togglePattern() {
                var on = $('#is_recurring').is(':checked');
                $('#recurring_pattern').prop('disabled', !on);
                if (!on) $('#recurring_pattern').val('');
            }
            $('#is_recurring').on('change', togglePattern);
            togglePattern();
        });
        </script>
    @endpush
</x-tenant-app-layout>
