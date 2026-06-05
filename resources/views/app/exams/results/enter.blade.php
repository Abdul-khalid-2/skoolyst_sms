<x-tenant-app-layout>
    <x-slot name="header"></x-slot>

    <div class="data-table-area mg-b-15">
        <div class="container-fluid">
            <div class="row">

                <x-page-header title="Enter Results — {{ $exam->name }}" :back-route="route('exams.results.index', $exam)" />

                {{-- Step 1: Select Class & Subject --}}
                <div class="col-lg-12">
                    <div style="background:#fff; border:1px solid #e0e0e0; border-radius:6px; padding:18px 20px; margin-bottom:20px;">
                        <h4 style="margin:0 0 14px; font-size:14px; font-weight:700;"><i class="fa fa-filter"></i> Step 1: Select Class & Subject</h4>
                        <div class="row">
                            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
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
                            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label>Section</label>
                                    <select id="result_section_id" class="form-control" disabled>
                                        <option value="">-- Select Section --</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label>Subject <span class="text-danger">*</span></label>
                                    <select id="result_subject_id" class="form-control">
                                        <option value="">-- Select Subject --</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <button id="btn_load_students" class="btn btn-primary btn-block">
                                        <i class="fa fa-users"></i> Load Students
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Step 2: Marks Entry Table --}}
                <div class="col-lg-12" id="marks_section" style="display:none;">
                    <form action="{{ route('exams.results.store', $exam) }}" method="POST">
                        @csrf

                        <input type="hidden" name="class_id"   id="hidden_class_id">
                        <input type="hidden" name="section_id" id="hidden_section_id">
                        <input type="hidden" name="subject_id" id="hidden_subject_id">

                        <div class="sparkline13-list">
                            <div class="sparkline13-hd">
                                <div class="main-sparkline13-hd" style="display:flex; justify-content:space-between; align-items:center;">
                                    <h1>Step 2: Enter Marks</h1>
                                    <div>
                                        <span id="marks_info" style="font-size:13px; color:#888; margin-right:12px;"></span>
                                        <button type="submit" class="btn btn-success btn-sm">
                                            <i class="fa fa-save"></i> Save All Results
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="sparkline13-graph">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Student Name</th>
                                                <th>Admission No</th>
                                                <th style="width:130px;">Marks Obtained</th>
                                                <th style="width:100px;">Grade</th>
                                                <th>Remarks</th>
                                            </tr>
                                        </thead>
                                        <tbody id="students_tbody">
                                            <tr>
                                                <td colspan="6" class="text-center text-muted" style="padding:30px;">
                                                    Select a class and subject above, then click <strong>Load Students</strong>.
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>

    @push('js')
        <script>
        $(document).ready(function () {

            // Load sections when class changes
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
                    url: '{{ route('attendance.get-sections') }}',
                    data: { class_id: classId },
                    success: function (res) {
                        var opts = '<option value="">All Sections</option>';
                        $.each(res.sections, function (i, s) {
                            opts += '<option value="' + s.id + '">' + s.name + '</option>';
                        });
                        $section.html(opts).prop('disabled', false);
                    }
                });

                // Load subjects for this class
                $.ajax({
                    url: '{{ route('attendance.get-subjects') }}',
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

            // Load students for marks entry
            $('#btn_load_students').on('click', function () {
                var classId   = $('#result_class_id').val();
                var sectionId = $('#result_section_id').val();
                var subjectId = $('#result_subject_id').val();
                var maxMarks  = 100; // will be dynamic when real data is added

                if (!classId || !subjectId) {
                    alert('Please select a class and subject.');
                    return;
                }

                $('#hidden_class_id').val(classId);
                $('#hidden_section_id').val(sectionId);
                $('#hidden_subject_id').val(subjectId);
                $('#marks_info').text('Max Marks: ' + maxMarks);

                $.ajax({
                    url: '{{ route('attendance.get-students') }}',
                    data: { class_id: classId, section_id: sectionId, date: '{{ now()->format('Y-m-d') }}' },
                    success: function (res) {
                        var rows = '';
                        if (!res.students || res.students.length === 0) {
                            rows = '<tr><td colspan="6" class="text-center text-muted" style="padding:20px;">No students found.</td></tr>';
                        } else {
                            $.each(res.students, function (i, sp) {
                                rows += '<tr>'
                                    + '<td>' + (i + 1) + '</td>'
                                    + '<td>' + (sp.student ? sp.student.name : 'N/A') + '</td>'
                                    + '<td>' + (sp.admission_no || 'N/A') + '</td>'
                                    + '<td><input type="number" name="results[' + (sp.student ? sp.student.id : '') + '][marks]" class="form-control input-sm" placeholder="0–' + maxMarks + '" min="0" max="' + maxMarks + '"></td>'
                                    + '<td><select name="results[' + (sp.student ? sp.student.id : '') + '][grade]" class="form-control input-sm"><option value="">—</option><option>A+</option><option>A</option><option>B</option><option>C</option><option>D</option><option>F</option></select></td>'
                                    + '<td><input type="text" name="results[' + (sp.student ? sp.student.id : '') + '][remarks]" class="form-control input-sm" placeholder="Optional"></td>'
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
