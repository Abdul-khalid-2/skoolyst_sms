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
            <div class="col-lg-4 col-md-10 col-sm-12 col-xs-12">

                {{-- Tips card --}}
                <div class="sparkline12-list" style="margin-bottom: 20px;">
                    <div class="sparkline12-graph">
                        <div class="basic-login-form-ad">
                            <h5 style="margin-top:0; color:#3c8dbc;">
                                <i class="fa fa-lightbulb-o"></i> How to create an exam
                            </h5>
                            <ol style="padding-left: 18px; line-height: 1.9; color: #555; font-size: 13px;">
                                <li>Give your exam a clear, descriptive <strong>name</strong>.</li>
                                <li>Set the <strong>Start</strong> and <strong>End Date</strong> — the period during which the exam runs.</li>
                                <li>Add an optional <strong>description</strong> for internal notes.</li>
                                <li>Tick <em>Publish immediately</em> so students can see it right away, or leave it unchecked to keep it as a draft.</li>
                                <li>After saving, open the exam and add <strong>schedule entries</strong> (subject, date, time, room) for each paper.</li>
                                <li>Finally, use <strong>Enter Results</strong> to record marks once the exam is over.</li>
                            </ol>
                        </div>
                    </div>
                </div>

                {{-- Example card --}}
                <div class="sparkline12-list">
                    <div class="sparkline12-graph">
                        <div class="basic-login-form-ad">
                            <h5 style="margin-top:0; color:#3c8dbc;">
                                <i class="fa fa-file-text-o"></i> Example
                            </h5>
                            <table class="table table-condensed table-bordered" style="font-size: 12px; margin-bottom: 0;">
                                <tbody>
                                    <tr>
                                        <th style="width:40%; background:#f5f5f5;">Exam Name</th>
                                        <td>Mid-Term Examination 2026</td>
                                    </tr>
                                    <tr>
                                        <th style="background:#f5f5f5;">Description</th>
                                        <td>Second semester mid-term for all classes.</td>
                                    </tr>
                                    <tr>
                                        <th style="background:#f5f5f5;">Start Date</th>
                                        <td>15 Jun 2026</td>
                                    </tr>
                                    <tr>
                                        <th style="background:#f5f5f5;">End Date</th>
                                        <td>25 Jun 2026</td>
                                    </tr>
                                    <tr>
                                        <th style="background:#f5f5f5;">Published</th>
                                        <td><span class="label label-success">Yes</span></td>
                                    </tr>
                                </tbody>
                            </table>
                            <p style="font-size: 12px; color: #888; margin-top: 10px; margin-bottom: 0;">
                                <i class="fa fa-info-circle"></i>
                                You can always edit these details later from the exam list.
                            </p>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-tenant-app-layout>
