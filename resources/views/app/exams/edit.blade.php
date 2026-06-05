<x-tenant-app-layout>
    <x-slot name="header"></x-slot>

    <div class="container-fluid">
        <div class="row">

            <x-page-header title="Edit Exam" :back-route="route('exams.show', $exam)" />

            <div class="col-lg-8 col-md-10 col-sm-12 col-xs-12">
                <div class="sparkline12-list">
                    <div class="sparkline12-graph">
                        <div class="basic-login-form-ad">
                            <form action="{{ route('exams.update', $exam) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Exam Name <span class="text-danger">*</span></label>
                                            <input type="text" name="name" class="form-control"
                                                value="{{ old('name', $exam->name) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Description</label>
                                            <textarea name="description" class="form-control" rows="3">{{ old('description', $exam->description) }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Start Date <span class="text-danger">*</span></label>
                                            <input type="date" name="start_date" class="form-control"
                                                value="{{ old('start_date', $exam->start_date) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>End Date <span class="text-danger">*</span></label>
                                            <input type="date" name="end_date" class="form-control"
                                                value="{{ old('end_date', $exam->end_date) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>
                                                <input type="checkbox" name="is_published" value="1"
                                                    {{ old('is_published', $exam->is_published) ? 'checked' : '' }}>
                                                &nbsp;Published (students can see this exam)
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-12" style="margin-top:10px;">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-save"></i> Update Exam
                                        </button>
                                        <a href="{{ route('exams.show', $exam) }}" class="btn btn-default" style="margin-left:8px;">
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
