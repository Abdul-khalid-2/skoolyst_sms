<x-tenant-app-layout>
    <x-slot name="header"></x-slot>

    <div class="container-fluid" style="margin-top: 20px;">
        <div class="row">

            <x-page-header
                title="Assign Subject Teachers"
                :back-route="route('admin.academic.classes.index')"
            />

            <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">

                {{-- Step 1: pick class + section --}}
                <div class="white-box" style="margin-bottom:20px;">
                    <h4 style="margin:0 0 14px; font-size:14px; font-weight:700;">
                        <i class="fa fa-filter"></i> Step 1: Select Class &amp; Section
                    </h4>
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-6">
                            <div class="form-group">
                                <label>Class <span class="text-danger">*</span></label>
                                <select id="st_class_id" class="form-control">
                                    <option value="">-- Select Class --</option>
                                    @foreach($classes as $class)
                                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-6">
                            <div class="form-group">
                                <label>Section <span class="text-danger">*</span></label>
                                <select id="st_section_id" class="form-control" disabled>
                                    <option value="">-- Select Section --</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-6">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <button id="st_load" type="button" class="btn btn-primary btn-block">
                                    <i class="fa fa-list"></i> Load Subjects
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Step 2: subjects + teacher dropdowns --}}
                <form action="{{ route('admin.academic.subjects.section_teacher.store') }}" method="POST" id="st_form" style="display:none;">
                    @csrf
                    <input type="hidden" name="class_id" id="st_hidden_class">
                    <input type="hidden" name="section_id" id="st_hidden_section">

                    <div class="white-box">
                        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
                            <h4 style="margin:0; font-size:14px; font-weight:700;">
                                <i class="fa fa-book"></i> Step 2: Assign Teacher per Subject
                                <small id="st_context" class="text-muted" style="margin-left:8px;"></small>
                            </h4>
                            <button type="submit" class="btn btn-success btn-sm">
                                <i class="fa fa-save"></i> Save Assignments
                            </button>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" style="margin-bottom:0;">
                                <thead style="background:#f5f5f5;">
                                    <tr>
                                        <th style="width:40px;">#</th>
                                        <th>Subject</th>
                                        <th>Code</th>
                                        <th style="width:40%;">Teacher</th>
                                    </tr>
                                </thead>
                                <tbody id="st_tbody"></tbody>
                            </table>
                        </div>
                    </div>
                </form>

            </div>

            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                <div class="white-box">
                    <h5 style="margin-top:0; color:#3c8dbc;">
                        <i class="fa fa-info-circle"></i> How it works
                    </h5>
                    <ol style="padding-left:18px; line-height:1.8; color:#555; font-size:13px;">
                        <li>Pick a <strong>class</strong> and <strong>section</strong>.</li>
                        <li>Each <strong>curriculum subject</strong> appears with a teacher dropdown.</li>
                        <li>The dropdown lists only teachers <strong>assigned to teach that subject</strong>.</li>
                        <li>Leave blank to clear an assignment.</li>
                    </ol>
                    <p style="font-size:12px; color:#888; margin-bottom:0;">
                        Tip: a teacher appears here only if the subject is assigned to them on the
                        <em>Assign Subjects</em> page.
                    </p>
                </div>
            </div>

        </div>
    </div>

    @push('js')
        <script>
        $(document).ready(function () {

            // Load sections when class changes
            $('#st_class_id').on('change', function () {
                var classId = $(this).val();
                var $section = $('#st_section_id');
                $('#st_form').hide();
                $section.html('<option value="">Loading...</option>').prop('disabled', true);

                if (!classId) {
                    $section.html('<option value="">-- Select Section --</option>').prop('disabled', true);
                    return;
                }

                $.get('{{ url('subject-teacher-assign/sections') }}/' + classId, function (res) {
                    var opts = '<option value="">-- Select Section --</option>';
                    $.each(res, function (id, name) {
                        opts += '<option value="' + id + '">' + name + '</option>';
                    });
                    $section.html(opts).prop('disabled', false);
                });
            });

            $('#st_section_id').on('change', function () {
                $('#st_form').hide();
            });

            // Load subjects + teacher dropdowns
            $('#st_load').on('click', function () {
                var classId   = $('#st_class_id').val();
                var sectionId = $('#st_section_id').val();

                if (!classId || !sectionId) {
                    alert('Please select a class and section.');
                    return;
                }

                $.ajax({
                    url: '{{ route('admin.academic.subjects.section_teacher.subjects') }}',
                    data: { class_id: classId, section_id: sectionId },
                    success: function (res) {
                        var rows = '';
                        if (!res.subjects || res.subjects.length === 0) {
                            rows = '<tr><td colspan="4" class="text-center text-muted" style="padding:20px;">'
                                 + 'No subjects in this class\'s curriculum. '
                                 + '<a href="{{ route('admin.academic.subjects.assign') }}#assign-class-subjects">Add subjects</a></td></tr>';
                        } else {
                            $.each(res.subjects, function (i, s) {
                                var teacherOpts = '<option value="">-- Not assigned --</option>';
                                $.each(s.teachers, function (j, t) {
                                    var sel = (s.assigned_teacher_id == t.id) ? ' selected' : '';
                                    teacherOpts += '<option value="' + t.id + '"' + sel + '>' + t.name + '</option>';
                                });

                                var noTeachers = s.teachers.length === 0
                                    ? '<br><small class="text-danger">No teacher is assigned to this subject yet.</small>'
                                    : '';

                                rows += '<tr>'
                                    + '<td>' + (i + 1) + '</td>'
                                    + '<td><i class="fa fa-book text-muted"></i> ' + s.name + '</td>'
                                    + '<td><span class="label label-default">' + s.code + '</span></td>'
                                    + '<td><select name="teachers[' + s.id + ']" class="form-control input-sm">' + teacherOpts + '</select>' + noTeachers + '</td>'
                                    + '</tr>';
                            });
                        }

                        $('#st_tbody').html(rows);
                        $('#st_hidden_class').val(classId);
                        $('#st_hidden_section').val(sectionId);
                        $('#st_context').text(
                            $('#st_class_id option:selected').text() + ' – ' + $('#st_section_id option:selected').text()
                        );
                        $('#st_form').show();
                    },
                    error: function () {
                        alert('Failed to load subjects. Please try again.');
                    }
                });
            });

        });
        </script>
    @endpush
</x-tenant-app-layout>
