<x-tenant-app-layout>
    <x-slot name="header"></x-slot>

    <div class="container-fluid">
        <div class="row">

            <x-page-header title="Create New Exam" :back-route="route('exams.index')" />

            <div class="col-lg-8 col-md-10 col-sm-12 col-xs-12">
                <div class="sparkline12-list">
                    <div class="sparkline12-graph">
                        <div class="basic-login-form-ad">
                            <form action="{{ route('exams.store') }}" method="POST">
                                @csrf

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Exam Name <span class="text-danger">*</span></label>
                                            <input type="text" name="name" class="form-control"
                                                placeholder="e.g. Mid-Term Examination 2026"
                                                value="{{ old('name') }}" required>
                                            @error('name')<small class="text-danger">{{ $message }}</small>@enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Description</label>
                                            <textarea name="description" class="form-control" rows="3"
                                                placeholder="Optional details about this exam">{{ old('description') }}</textarea>
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
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>
                                                <input type="checkbox" name="is_published" value="1"
                                                    {{ old('is_published') ? 'checked' : '' }}>
                                                &nbsp;Publish immediately (students can see this exam)
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-12" style="margin-top:10px;">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-save"></i> Create Exam
                                        </button>
                                        <a href="{{ route('exams.index') }}" class="btn btn-default" style="margin-left:8px;">
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
