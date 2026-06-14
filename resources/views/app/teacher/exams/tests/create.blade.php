<x-tenant-app-layout>
    <x-slot name="header"></x-slot>

    <div class="container-fluid" style="margin-top: 20px;">

        <div class="row" style="margin-bottom: 15px;">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <h3 style="margin: 0; line-height: 34px;">
                    <i class="fa fa-plus"></i> Schedule Class Test
                </h3>
                <small class="text-muted">Add a test schedule for your class and subject</small>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
                <a href="{{ route('teacher.exams.tests.index') }}" class="btn btn-default btn-sm">
                    <i class="fa fa-arrow-left"></i> Back
                </a>
            </div>
        </div>

        @if($classes->isEmpty())
            <div class="white-box">
                <p class="text-muted text-center" style="padding: 30px 0;">
                    <i class="fa fa-info-circle fa-3x" style="display:block; margin-bottom:12px;"></i>
                    You have no classes assigned yet, so you cannot schedule a test.
                </p>
            </div>
        @elseif($exams->isEmpty())
            <div class="white-box">
                <p class="text-muted text-center" style="padding: 30px 0;">
                    <i class="fa fa-info-circle fa-3x" style="display:block; margin-bottom:12px;"></i>
                    No active exam periods are available. Please contact the administrator.
                </p>
            </div>
        @else
        <div class="row">
            <div class="col-lg-8 col-md-7 col-sm-12">
                <div class="white-box">
                    <form action="{{ route('teacher.exams.tests.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Exam Period <span class="text-danger">*</span></label>
                                    <select name="exam_id" class="form-control" required>
                                        <option value="">-- Select Exam --</option>
                                        @foreach($exams as $exam)
                                            <option value="{{ $exam->id }}" {{ old('exam_id') == $exam->id ? 'selected' : '' }}>
                                                {{ $exam->name }}
                                                ({{ \Carbon\Carbon::parse($exam->start_date)->format('d M') }} – {{ \Carbon\Carbon::parse($exam->end_date)->format('d M Y') }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('exam_id')<small class="text-danger">{{ $message }}</small>@enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Class <span class="text-danger">*</span></label>
                                    <select name="class_id" id="class_id" class="form-control" required>
                                        <option value="">-- Select Class --</option>
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
                                    <label>Subject <span class="text-danger">*</span></label>
                                    <select name="subject_id" id="subject_id" class="form-control" required>
                                        <option value="">-- Select Subject --</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Test Date <span class="text-danger">*</span></label>
                                    <input type="date" name="exam_date" class="form-control" value="{{ old('exam_date') }}" required>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Start Time</label>
                                    <input type="time" name="start_time" class="form-control" value="{{ old('start_time') }}">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>End Time</label>
                                    <input type="time" name="end_time" class="form-control" value="{{ old('end_time') }}">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Room</label>
                                    <input type="text" name="room_number" class="form-control" placeholder="e.g. Room 101" value="{{ old('room_number') }}">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Max Marks</label>
                                    <input type="number" name="max_marks" class="form-control" min="1" value="{{ old('max_marks', 100) }}">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Passing Marks</label>
                                    <input type="number" name="passing_marks" class="form-control" min="1" value="{{ old('passing_marks', 40) }}">
                                </div>
                            </div>
                            <div class="col-lg-12" style="margin-top:10px;">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save"></i> Save Test Schedule
                                </button>
                                <a href="{{ route('teacher.exams.tests.index') }}" class="btn btn-default" style="margin-left:8px;">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-lg-4 col-md-5 col-sm-12">

                {{-- Guide: how to schedule --}}
                <div class="white-box" style="margin-bottom: 20px;">
                    <h5 style="margin-top:0; color:#3c8dbc;">
                        <i class="fa fa-lightbulb-o"></i> How to schedule a class test
                    </h5>
                    <ol style="padding-left: 18px; line-height: 1.9; color: #555; font-size: 13px; margin-bottom: 0;">
                        <li>Select the <strong>Exam Period</strong> this test belongs to.</li>
                        <li>Choose the <strong>Class</strong> you teach — only your assigned classes are listed.</li>
                        <li>Pick the <strong>Subject</strong> for that class; subjects load after you select a class.</li>
                        <li>Set the <strong>Test Date</strong> — it must fall within the exam period dates.</li>
                        <li>Enter <strong>Start &amp; End Time</strong> and a <strong>Room</strong> so students know when and where to appear.</li>
                        <li>Set <strong>Max Marks</strong> and <strong>Passing Marks</strong> — these are used when you enter results later.</li>
                        <li>Click <strong>Save Test Schedule</strong>, then use <em>Enter Marks</em> once the test is done.</li>
                    </ol>
                </div>

                {{-- Guide: example --}}
                <div class="white-box" style="margin-bottom: 20px;">
                    <h5 style="margin-top:0; color:#3c8dbc;">
                        <i class="fa fa-file-text-o"></i> Example entry
                    </h5>
                    <table class="table table-condensed table-bordered" style="font-size: 12px; margin-bottom: 0;">
                        <tbody>
                            <tr>
                                <th style="width:42%; background:#f5f5f5;">Exam Period</th>
                                <td>Mid-Term 2026</td>
                            </tr>
                            <tr>
                                <th style="background:#f5f5f5;">Class</th>
                                <td>Class 8</td>
                            </tr>
                            <tr>
                                <th style="background:#f5f5f5;">Subject</th>
                                <td>Mathematics</td>
                            </tr>
                            <tr>
                                <th style="background:#f5f5f5;">Test Date</th>
                                <td>17 Jun 2026</td>
                            </tr>
                            <tr>
                                <th style="background:#f5f5f5;">Start Time</th>
                                <td>09:00 AM</td>
                            </tr>
                            <tr>
                                <th style="background:#f5f5f5;">End Time</th>
                                <td>11:00 AM</td>
                            </tr>
                            <tr>
                                <th style="background:#f5f5f5;">Room</th>
                                <td>Room 101</td>
                            </tr>
                            <tr>
                                <th style="background:#f5f5f5;">Max / Pass</th>
                                <td>100 / 40</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                {{-- Guide: notes --}}
                <div class="white-box">
                    <h5 style="margin-top:0; color:#e08e0b;">
                        <i class="fa fa-exclamation-triangle"></i> Things to keep in mind
                    </h5>
                    <ul style="padding-left: 18px; line-height: 1.9; color: #555; font-size: 13px; margin-bottom: 0;">
                        <li>You can only schedule tests for <strong>classes and subjects you teach</strong>.</li>
                        <li>The test date must be <strong>within the selected exam period</strong>.</li>
                        <li>End time must be <strong>after</strong> the start time.</li>
                        <li>Passing marks must not exceed max marks.</li>
                        <li>Schedule one entry per class–subject combination for each exam period.</li>
                        <li>After saving, record scores from the <strong>Enter Marks</strong> page.</li>
                    </ul>
                </div>

            </div>
        </div>
        @endif

    </div>

    @push('js')
        <script>
        $(document).ready(function () {
            function loadSubjects(classId, selected) {
                var $subject = $('#subject_id');
                $subject.html('<option value="">Loading...</option>');

                if (!classId) {
                    $subject.html('<option value="">-- Select Subject --</option>');
                    return;
                }

                $.ajax({
                    url: '{{ route('teacher.exams.tests.subjects') }}',
                    data: { class_id: classId },
                    success: function (res) {
                        var opts = '<option value="">-- Select Subject --</option>';
                        $.each(res.subjects, function (i, s) {
                            var sel = (selected && selected == s.id) ? ' selected' : '';
                            opts += '<option value="' + s.id + '"' + sel + '>' + s.name + '</option>';
                        });
                        $subject.html(opts);
                    },
                    error: function () {
                        $subject.html('<option value="">-- Select Subject --</option>');
                    }
                });
            }

            $('#class_id').on('change', function () {
                loadSubjects($(this).val(), null);
            });

            @if(old('class_id'))
                loadSubjects('{{ old('class_id') }}', '{{ old('subject_id') }}');
            @endif
        });
        </script>
    @endpush
</x-tenant-app-layout>
