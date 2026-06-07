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
            <div class="col-lg-12">
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
            </div>

            <div class="col-lg-12" id="marks_section" style="display:none;">
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
