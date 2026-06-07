<x-tenant-app-layout>
    <x-slot name="header"></x-slot>

    <div class="container-fluid">
        <div class="row">

            <x-page-header title="Add Schedule — {{ $exam->name }}" :back-route="route('exams.show', $exam)" />

            <div class="col-lg-8 col-md-10 col-sm-12 col-xs-12">
                <div class="sparkline12-list">
                    <div class="sparkline12-graph">
                        <div class="basic-login-form-ad">
                            <form action="{{ route('exams.schedule.store', $exam) }}" method="POST">
                                @csrf

                                @if($errors->any())
                                    <div class="alert alert-danger" style="margin-bottom:15px;">
                                        <strong><i class="fa fa-exclamation-circle"></i> Please fix the following:</strong>
                                        <ul style="margin:8px 0 0 18px; padding:0;">
                                            @foreach($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Class <span class="text-danger">*</span></label>
                                            <select name="class_id" id="schedule_class_id" class="form-control @error('class_id') is-invalid @enderror" required>
                                                <option value="">-- Select Class --</option>
                                                @foreach($classes as $class)
                                                    <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                                        {{ $class->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('class_id')<small class="text-danger">{{ $message }}</small>@enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Subject <span class="text-danger">*</span></label>
                                            <select name="subject_id" id="schedule_subject_id" class="form-control @error('subject_id') is-invalid @enderror" required>
                                                <option value="">-- Select Class First --</option>
                                            </select>
                                            <small class="text-muted">Only subjects in the selected class's curriculum are shown.</small>
                                            @error('subject_id')<small class="text-danger" style="display:block;">{{ $message }}</small>@enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Exam Date <span class="text-danger">*</span></label>
                                            <input type="date" name="exam_date" class="form-control @error('exam_date') is-invalid @enderror"
                                                value="{{ old('exam_date') }}" required>
                                            @error('exam_date')<small class="text-danger">{{ $message }}</small>@enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Start Time</label>
                                            <input type="time" name="start_time" class="form-control @error('start_time') is-invalid @enderror"
                                                value="{{ old('start_time') }}">
                                            @error('start_time')<small class="text-danger">{{ $message }}</small>@enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>End Time</label>
                                            <input type="time" name="end_time" class="form-control @error('end_time') is-invalid @enderror"
                                                value="{{ old('end_time') }}">
                                            @error('end_time')<small class="text-danger">{{ $message }}</small>@enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Room / Hall</label>
                                            <input type="text" name="room_number" class="form-control @error('room_number') is-invalid @enderror"
                                                placeholder="e.g. Room 101"
                                                value="{{ old('room_number') }}">
                                            @error('room_number')<small class="text-danger">{{ $message }}</small>@enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Max Marks</label>
                                            <input type="number" name="max_marks" class="form-control @error('max_marks') is-invalid @enderror"
                                                placeholder="100" min="1"
                                                value="{{ old('max_marks', 100) }}">
                                            @error('max_marks')<small class="text-danger">{{ $message }}</small>@enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Passing Marks</label>
                                            <input type="number" name="passing_marks" class="form-control @error('passing_marks') is-invalid @enderror"
                                                placeholder="40" min="1"
                                                value="{{ old('passing_marks', 40) }}">
                                            @error('passing_marks')<small class="text-danger">{{ $message }}</small>@enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-12" style="margin-top:10px;">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-save"></i> Save Schedule
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
                                <i class="fa fa-lightbulb-o"></i> How to add a schedule entry
                            </h5>
                            <ol style="padding-left: 18px; line-height: 1.9; color: #555; font-size: 13px;">
                                <li>Select the <strong>Class</strong> that will sit this paper.</li>
                                <li>Choose the <strong>Subject</strong> being examined.</li>
                                <li>Pick the <strong>Exam Date</strong> — must fall within <em>{{ \Carbon\Carbon::parse($exam->start_date)->format('d M Y') }} – {{ \Carbon\Carbon::parse($exam->end_date)->format('d M Y') }}</em>.</li>
                                <li>Enter <strong>Start &amp; End Time</strong> so the timetable is clear for students and invigilators.</li>
                                <li>Specify the <strong>Room / Hall</strong> where the exam takes place.</li>
                                <li>Set <strong>Max Marks</strong> and <strong>Passing Marks</strong> — these are used when entering results later.</li>
                                <li>Repeat this form for every class–subject combination in this exam.</li>
                            </ol>
                        </div>
                    </div>
                </div>

                {{-- Example card --}}
                <div class="sparkline12-list" style="margin-bottom: 20px;">
                    <div class="sparkline12-graph">
                        <div class="basic-login-form-ad">
                            <h5 style="margin-top:0; color:#3c8dbc;">
                                <i class="fa fa-file-text-o"></i> Example entry
                            </h5>
                            <table class="table table-condensed table-bordered" style="font-size: 12px; margin-bottom: 0;">
                                <tbody>
                                    <tr>
                                        <th style="width:42%; background:#f5f5f5;">Class</th>
                                        <td>Class 8</td>
                                    </tr>
                                    <tr>
                                        <th style="background:#f5f5f5;">Subject</th>
                                        <td>Mathematics</td>
                                    </tr>
                                    <tr>
                                        <th style="background:#f5f5f5;">Exam Date</th>
                                        <td>17 Jun 2026</td>
                                    </tr>
                                    <tr>
                                        <th style="background:#f5f5f5;">Start Time</th>
                                        <td>09:00 AM</td>
                                    </tr>
                                    <tr>
                                        <th style="background:#f5f5f5;">End Time</th>
                                        <td>12:00 PM</td>
                                    </tr>
                                    <tr>
                                        <th style="background:#f5f5f5;">Room</th>
                                        <td>Hall A</td>
                                    </tr>
                                    <tr>
                                        <th style="background:#f5f5f5;">Max / Pass</th>
                                        <td>100 / 40</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Note card --}}
                <div class="sparkline12-list">
                    <div class="sparkline12-graph">
                        <div class="basic-login-form-ad">
                            <h5 style="margin-top:0; color:#e08e0b;">
                                <i class="fa fa-exclamation-triangle"></i> Things to keep in mind
                            </h5>
                            <ul style="padding-left: 18px; line-height: 1.9; color: #555; font-size: 13px; margin-bottom: 0;">
                                <li>Each <strong>Class + Subject</strong> combination should appear only once per exam.</li>
                                <li>Passing marks must not exceed max marks.</li>
                                <li>Students will see the schedule only if the exam is <strong>published</strong>.</li>
                                <li>You can edit or delete schedule entries from the exam detail page.</li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

    @push('js')
        <script>
        $(document).ready(function () {
            var subjectsUrl  = '{{ route('exams.schedule.subjects', $exam) }}';
            var oldSubjectId = '{{ old('subject_id') }}';

            function loadSubjects(classId, selectId) {
                var $subject = $('#schedule_subject_id');

                if (!classId) {
                    $subject.html('<option value="">-- Select Class First --</option>');
                    return;
                }

                $subject.html('<option value="">Loading...</option>');

                $.get(subjectsUrl, { class_id: classId }, function (res) {
                    var opts = '<option value="">-- Select Subject --</option>';
                    if (!res.subjects || res.subjects.length === 0) {
                        opts = '<option value="">No subjects in this class\'s curriculum</option>';
                    } else {
                        $.each(res.subjects, function (i, s) {
                            var sel = (selectId && selectId == s.id) ? ' selected' : '';
                            opts += '<option value="' + s.id + '"' + sel + '>' + s.name + ' (' + s.code + ')</option>';
                        });
                    }
                    $subject.html(opts);
                });
            }

            $('#schedule_class_id').on('change', function () {
                loadSubjects($(this).val(), null);
            });

            // Restore subjects if the form reloaded with a previously chosen class (validation error).
            var initialClass = $('#schedule_class_id').val();
            if (initialClass) {
                loadSubjects(initialClass, oldSubjectId);
            }
        });
        </script>
    @endpush
</x-tenant-app-layout>
