<x-tenant-app-layout>
    <x-slot name="header"></x-slot>

    <div class="container-fluid" style="margin-top: 20px;">

        <div class="row" style="margin-bottom: 15px;">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <h3 style="margin: 0; line-height: 34px;">
                    <i class="fa fa-pencil"></i> Enter Marks — {{ $exam->name }}
                </h3>
                <small class="text-muted">Record marks for your class and subject</small>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
                <a href="{{ route('teacher.exams.marks.index') }}" class="btn btn-default btn-sm">
                    <i class="fa fa-arrow-left"></i> Back
                </a>
            </div>
        </div>

        @if($classes->isEmpty())
            <div class="white-box">
                <p class="text-muted text-center" style="padding: 30px 0;">
                    You have no classes assigned for marks entry.
                </p>
            </div>
        @else
        <div class="row">
            <div class="col-lg-8 col-md-7 col-sm-12">

                <div class="white-box" style="margin-bottom: 20px;">
                    <h4 style="margin:0 0 14px; font-size:14px; font-weight:700;">
                        <i class="fa fa-filter"></i> Step 1: Select Class & Subject
                    </h4>
                    <div class="row">
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="form-group">
                                <label>Class <span class="text-danger">*</span></label>
                                <select id="result_class_id" class="form-control">
                                    <option value="">-- Select Class --</option>
                                    @foreach($classes as $class)
                                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="form-group">
                                <label>Section</label>
                                <select id="result_section_id" class="form-control" disabled>
                                    <option value="">-- Select Section --</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="form-group">
                                <label>Subject <span class="text-danger">*</span></label>
                                <select id="result_subject_id" class="form-control">
                                    <option value="">-- Select Subject --</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <button id="btn_load_students" type="button" class="btn btn-primary btn-block">
                                    <i class="fa fa-users"></i> Load Students
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="marks_section" style="display:none;">
                    <form action="{{ route('teacher.exams.marks.store', $exam) }}" method="POST">
                        @csrf
                        <input type="hidden" name="class_id" id="hidden_class_id">
                        <input type="hidden" name="subject_id" id="hidden_subject_id">

                        <div class="white-box">
                            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
                                <h4 style="margin:0; font-size:14px; font-weight:700;">Step 2: Enter Marks</h4>
                                <div>
                                    <span id="marks_info" style="font-size:13px; color:#888; margin-right:12px;"></span>
                                    <button type="submit" class="btn btn-success btn-sm">
                                        <i class="fa fa-save"></i> Save Results
                                    </button>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Student Name</th>
                                            <th>Admission No</th>
                                            <th style="width:130px;">Marks</th>
                                            <th style="width:100px;">Grade</th>
                                            <th>Remarks</th>
                                        </tr>
                                    </thead>
                                    <tbody id="students_tbody">
                                        <tr>
                                            <td colspan="6" class="text-center text-muted" style="padding:30px;">
                                                Select a class and subject, then click <strong>Load Students</strong>.
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </form>
                </div>

            </div>

            <div class="col-lg-4 col-md-5 col-sm-12">

                {{-- Guide: how to enter marks --}}
                <div class="white-box" style="margin-bottom: 20px;">
                    <h5 style="margin-top:0; color:#3c8dbc;">
                        <i class="fa fa-lightbulb-o"></i> How to enter marks
                    </h5>
                    <ol style="padding-left: 18px; line-height: 1.9; color: #555; font-size: 13px; margin-bottom: 0;">
                        <li>Select the <strong>Class</strong> you teach — only your assigned classes are listed.</li>
                        <li>Optionally pick a <strong>Section</strong>, or leave it as <em>All Sections</em>.</li>
                        <li>Choose the <strong>Subject</strong> for which you want to record marks.</li>
                        <li>Click <strong>Load Students</strong> to fetch the student list and any marks already saved.</li>
                        <li>Enter each student's <strong>Marks</strong> (within the max marks shown above the table).</li>
                        <li>Set a <strong>Grade</strong> manually, or leave blank to auto-calculate from marks.</li>
                        <li>Add optional <strong>Remarks</strong>, then click <strong>Save Results</strong>.</li>
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
                                <th style="width:42%; background:#f5f5f5;">Exam</th>
                                <td>{{ $exam->name }}</td>
                            </tr>
                            <tr>
                                <th style="background:#f5f5f5;">Class / Section</th>
                                <td>Class 8 — Section A</td>
                            </tr>
                            <tr>
                                <th style="background:#f5f5f5;">Subject</th>
                                <td>Mathematics</td>
                            </tr>
                            <tr>
                                <th style="background:#f5f5f5;">Student</th>
                                <td>Ahmed Raza (ADM-1024)</td>
                            </tr>
                            <tr>
                                <th style="background:#f5f5f5;">Marks</th>
                                <td>78 / 100</td>
                            </tr>
                            <tr>
                                <th style="background:#f5f5f5;">Grade</th>
                                <td>B</td>
                            </tr>
                            <tr>
                                <th style="background:#f5f5f5;">Remarks</th>
                                <td>Good performance</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                {{-- Guide: grade scale --}}
                <div class="white-box" style="margin-bottom: 20px;">
                    <h5 style="margin-top:0; color:#3c8dbc;">
                        <i class="fa fa-info-circle"></i> Grade guide
                    </h5>
                    <table class="table table-condensed" style="font-size: 12px; margin-bottom: 0;">
                        <tbody>
                            <tr>
                                <th style="width:35%; background:#f5f5f5;">A+</th>
                                <td style="color:#555;">90% and above</td>
                            </tr>
                            <tr>
                                <th style="background:#f5f5f5;">A</th>
                                <td style="color:#555;">80% – 89%</td>
                            </tr>
                            <tr>
                                <th style="background:#f5f5f5;">B</th>
                                <td style="color:#555;">70% – 79%</td>
                            </tr>
                            <tr>
                                <th style="background:#f5f5f5;">C</th>
                                <td style="color:#555;">60% – 69%</td>
                            </tr>
                            <tr>
                                <th style="background:#f5f5f5;">D</th>
                                <td style="color:#555;">50% – 59%</td>
                            </tr>
                            <tr>
                                <th style="background:#f5f5f5;">F</th>
                                <td style="color:#555;">Below 50%</td>
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
                        <li>You can only enter marks for <strong>classes and subjects you teach</strong>.</li>
                        <li>Max and passing marks come from the <strong>test schedule</strong> you created earlier.</li>
                        <li>Students with a <strong>blank marks field are skipped</strong> when saving.</li>
                        <li>If grade is left empty, it is <strong>calculated automatically</strong> from marks.</li>
                        <li>Previously saved marks are loaded when you click <strong>Load Students</strong> again.</li>
                        <li>Results become visible to students once the exam is <strong>published</strong> by admin.</li>
                    </ul>
                </div>

            </div>
        </div>
        @endif

    </div>

    @push('js')
        <script>
        $(document).ready(function () {

            $('#result_class_id').on('change', function () {
                var classId = $(this).val();
                var $section = $('#result_section_id');
                var $subject = $('#result_subject_id');

                $section.html('<option value="">Loading...</option>').prop('disabled', true);
                $subject.html('<option value="">-- Select Subject --</option>');
                $('#marks_section').hide();

                if (!classId) {
                    $section.html('<option value="">-- Select Section --</option>').prop('disabled', true);
                    return;
                }

                $.ajax({
                    url: '{{ route('teacher.exams.marks.sections') }}',
                    data: { class_id: classId },
                    success: function (res) {
                        var opts = '<option value="">All Sections</option>';
                        $.each(res.sections, function (i, s) {
                            opts += '<option value="' + s.id + '">' + s.name + '</option>';
                        });
                        $section.html(opts).prop('disabled', false);
                    }
                });

                $.ajax({
                    url: '{{ route('teacher.exams.marks.subjects') }}',
                    data: { class_id: classId },
                    success: function (res) {
                        var opts = '<option value="">-- Select Subject --</option>';
                        $.each(res.subjects, function (i, s) {
                            opts += '<option value="' + s.id + '">' + s.name + '</option>';
                        });
                        $subject.html(opts);
                    }
                });
            });

            $('#btn_load_students').on('click', function () {
                var classId   = $('#result_class_id').val();
                var sectionId = $('#result_section_id').val();
                var subjectId = $('#result_subject_id').val();

                if (!classId || !subjectId) {
                    alert('Please select a class and subject.');
                    return;
                }

                $('#hidden_class_id').val(classId);
                $('#hidden_subject_id').val(subjectId);

                $.ajax({
                    url: '{{ route('teacher.exams.marks.students', $exam) }}',
                    data: { class_id: classId, section_id: sectionId, subject_id: subjectId },
                    success: function (res) {
                        var maxMarks = res.max_marks || 100;
                        $('#marks_info').text('Max Marks: ' + maxMarks + ' | Pass: ' + (res.pass_marks || 40));

                        var rows = '';
                        if (!res.students || res.students.length === 0) {
                            rows = '<tr><td colspan="6" class="text-center text-muted" style="padding:20px;">No students found.</td></tr>';
                        } else {
                            $.each(res.students, function (i, sp) {
                                var sid = sp.student ? sp.student.id : '';
                                var existing = res.existing && res.existing[sid] ? res.existing[sid] : null;
                                var marksVal = existing ? existing.marks_obtained : '';
                                var gradeVal = existing ? existing.grade : '';
                                var remarksVal = existing ? (existing.remarks || '') : '';

                                rows += '<tr>'
                                    + '<td>' + (i + 1) + '</td>'
                                    + '<td>' + (sp.student ? sp.student.name : 'N/A') + '</td>'
                                    + '<td>' + (sp.admission_no || 'N/A') + '</td>'
                                    + '<td><input type="number" name="results[' + sid + '][marks]" class="form-control input-sm" value="' + marksVal + '" placeholder="0–' + maxMarks + '" min="0" max="' + maxMarks + '"></td>'
                                    + '<td><select name="results[' + sid + '][grade]" class="form-control input-sm">'
                                    + '<option value="">—</option>'
                                    + ['A+','A','B','C','D','F'].map(function (g) {
                                        return '<option' + (gradeVal === g ? ' selected' : '') + '>' + g + '</option>';
                                    }).join('')
                                    + '</select></td>'
                                    + '<td><input type="text" name="results[' + sid + '][remarks]" class="form-control input-sm" value="' + remarksVal + '" placeholder="Optional"></td>'
                                    + '</tr>';
                            });
                        }
                        $('#students_tbody').html(rows);
                        $('#marks_section').show();
                    },
                    error: function () {
                        alert('Failed to load students. Please try again.');
                    }
                });
            });

        });
        </script>
    @endpush
</x-tenant-app-layout>
