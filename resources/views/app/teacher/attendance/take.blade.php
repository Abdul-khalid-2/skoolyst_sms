<x-tenant-app-layout>
    @push('css')
        <link rel="stylesheet" href="{{ asset('backend/css/select2/select2.min.css') }}">
    <style>
        .alert-notification {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            min-width: 300px;
        }
        .student-photo {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }
        .status-present { background-color: #d4edda; }
        .status-absent  { background-color: #f8d7da; }
        .status-late    { background-color: #fff3cd; }
        .status-undefined { background-color: #e2e3e5; }
        .attendance-actions {
            position: sticky;
            bottom: 0;
            background: white;
            padding: 15px;
            border-top: 1px solid #eee;
            box-shadow: 0 -2px 10px rgba(0,0,0,0.05);
        }
        .attendance-btn-present { color: #3c763d; border-color: #3c763d; background-color: #fff; }
        .attendance-btn-absent  { color: #a94442; border-color: #a94442; background-color: #fff; }
        .attendance-btn-late    { color: #8a6d3b; border-color: #8a6d3b; background-color: #fff; }
        .attendance-btn-present.active, .attendance-btn-present:active {
            background-color: #3c763d !important; color: #fff !important; border-color: #3c763d !important;
        }
        .attendance-btn-absent.active, .attendance-btn-absent:active {
            background-color: #a94442 !important; color: #fff !important; border-color: #a94442 !important;
        }
        .attendance-btn-late.active, .attendance-btn-late:active {
            background-color: #f0ad4e !important; color: #333 !important; border-color: #eea236 !important;
        }
    </style>
    @endpush
    <x-slot name="header"></x-slot>

    <div class="container-fluid" style="margin-top: 20px;">
        <div class="row" style="margin-bottom: 15px;">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <h3 style="margin: 0; line-height: 34px;">
                    <i class="fa fa-calendar-check-o"></i> Mark Attendance
                </h3>
                <small class="text-muted">Take attendance for the classes you teach</small>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
                <a href="{{ route('dashboard') }}" class="btn btn-default btn-sm">
                    <i class="fa fa-arrow-left"></i> Back
                </a>
            </div>
        </div>

        @if($classes->isEmpty())
            <div class="white-box">
                <p class="text-muted text-center" style="padding: 30px 0;">
                    <i class="fa fa-info-circle fa-3x" style="display:block; margin-bottom:12px;"></i>
                    You have no classes assigned yet, so there is nothing to mark.
                </p>
            </div>
        @else
        <div class="row">
            <div class="col-lg-12">
                <div class="white-box">
                    <form id="attendanceForm" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Class *</label>
                                    <select class="form-control" id="class_id" name="class_id" required>
                                        <option value="">Select Class</option>
                                        @foreach($classes as $class)
                                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Section *</label>
                                    <select class="form-control" id="section_id" name="section_id" required disabled>
                                        <option value="">Select Section</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Date *</label>
                                    <input type="date" class="form-control" id="attendance_date" name="date"
                                        value="{{ date('Y-m-d') }}" max="{{ date('Y-m-d') }}" required>
                                </div>
                            </div>
                        </div>
                        <div id="class_check_result" class="text-muted" style="margin-bottom: 10px;">
                            Select class, section, and date to continue.
                        </div>
                        <div class="text-right">
                            <button type="button" id="loadStudentsBtn" class="btn btn-primary" disabled>
                                <i class="fa fa-users"></i> Load Students
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="row" id="attendanceSection" style="display: none;">
            <div class="col-lg-12">
                <div class="white-box">
                    <div class="row" style="margin-bottom: 10px;">
                        <div class="col-md-6">
                            <h3 class="box-title" style="margin:0;">Mark Attendance for <span id="classSectionTitle"></span></h3>
                        </div>
                        <div class="col-md-6 text-right">
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-success bulk-action-btn" data-status="present">
                                    <i class="fa fa-check"></i> All Present
                                </button>
                                <button type="button" class="btn btn-sm btn-danger bulk-action-btn" data-status="absent">
                                    <i class="fa fa-times"></i> All Absent
                                </button>
                                <button type="button" class="btn btn-sm btn-warning bulk-action-btn" data-status="late">
                                    <i class="fa fa-clock-o"></i> All Late
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="attendanceTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Photo</th>
                                    <th>Student Name</th>
                                    <th>Admission No.</th>
                                    <th>Status</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            <tbody id="studentsList"></tbody>
                        </table>
                    </div>
                    <div class="attendance-actions">
                        <div class="row">
                            <div class="col-md-6">
                                <span class="label label-success">Present: <span id="presentCount">0</span></span>
                                <span class="label label-danger">Absent: <span id="absentCount">0</span></span>
                                <span class="label label-warning">Late: <span id="lateCount">0</span></span>
                                <span class="label label-info">Total: <span id="totalCount">0</span></span>
                            </div>
                            <div class="col-md-6 text-right">
                                <button type="button" id="saveAsDraftBtn" class="btn btn-default">
                                    <i class="fa fa-save"></i> Save as Draft
                                </button>
                                <button type="button" id="submitAttendanceBtn" class="btn btn-primary">
                                    <i class="fa fa-check-circle"></i> Submit Attendance
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- My marked attendance records --}}
        <div class="row">
            <div class="col-lg-12">
                <div class="white-box">
                    <h3 class="box-title"><i class="fa fa-history"></i> My Marked Attendance</h3>

                    @if($sessions->isEmpty())
                        <p class="text-muted text-center" style="padding: 30px 0;">
                            <i class="fa fa-inbox fa-3x" style="display:block; margin-bottom:12px;"></i>
                            You have not marked any attendance yet. Submitted records will appear here.
                        </p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Class</th>
                                        <th>Section</th>
                                        <th>Present</th>
                                        <th>Absent</th>
                                        <th>Late</th>
                                        <th>%</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sessions as $session)
                                        @php
                                            $total   = $session->attendances->count();
                                            $present = $session->attendances->where('status', 'present')->count();
                                            $absent  = $session->attendances->where('status', 'absent')->count();
                                            $late    = $session->attendances->where('status', 'late')->count();
                                            $pct     = $total > 0 ? round(($present / $total) * 100, 1) : 0;
                                        @endphp
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($session->date)->format('d M Y') }}</td>
                                            <td>{{ $session->schoolClass->name ?? '—' }}</td>
                                            <td>{{ $session->section->name ?? '—' }}</td>
                                            <td><span class="text-success">{{ $present }}</span></td>
                                            <td><span class="text-danger">{{ $absent }}</span></td>
                                            <td><span class="text-warning">{{ $late }}</span></td>
                                            <td>{{ $pct }}%</td>
                                            <td>
                                                @if($session->status === 'submitted')
                                                    <span class="label label-success">Submitted</span>
                                                @else
                                                    <span class="label label-warning">Draft</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('teacher.attendance.show', $session->id) }}" class="btn btn-xs btn-info">
                                                    <i class="fa fa-eye"></i> View Roster
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('js')
        <script src="{{ asset('backend/js/vendor/jquery-1.12.4.min.js') }}"></script>
        <script src="{{ asset('backend/js/bootstrap.min.js') }}"></script>
        <script>
            const DEFAULT_PHOTO = '{{ asset('backend/img/profile/1.jpg') }}';

            function showAlert(type, message) {
                $('.alert-notification').remove();
                const alertHtml = `
                    <div class="alert alert-${type} alert-dismissible fade in alert-notification">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        ${message}
                    </div>`;
                $('body').append(alertHtml);
                setTimeout(() => { $('.alert-notification').alert('close'); }, 5000);
            }

            function studentPhotoUrl(profilePic, photoUrl) {
                if (photoUrl) return photoUrl;
                if (!profilePic) return DEFAULT_PHOTO;
                if (/^https?:\/\//i.test(profilePic)) return profilePic;
                return '{{ asset('assets') }}/' + profilePic.replace(/^\/+/, '');
            }

            $(document).ready(function () {
                function updateCounters(present, absent, late, total) {
                    $('#presentCount').text(present);
                    $('#absentCount').text(absent);
                    $('#lateCount').text(late);
                    $('#totalCount').text(total);
                }

                function recountAllStatuses() {
                    let present = 0, absent = 0, late = 0;
                    const total = $('#studentsList tr').length;
                    $('#studentsList tr').each(function () {
                        const status = $(this).find('input[type="radio"]:checked').val();
                        if (status === 'present') present++;
                        else if (status === 'absent') absent++;
                        else if (status === 'late') late++;
                    });
                    updateCounters(present, absent, late, total);
                }

                function refreshAttendanceAvailability() {
                    const classId = $('#class_id').val();
                    const sectionId = $('#section_id').val();
                    const date = $('#attendance_date').val();
                    const $result = $('#class_check_result');

                    $('#loadStudentsBtn').prop('disabled', true);

                    if (!classId) { $result.html('<span class="text-muted">Select a class to load sections.</span>'); return; }
                    if (!sectionId) { $result.html('<span class="text-muted">Select a section for the chosen class.</span>'); return; }
                    if (!date) { $result.html('<span class="text-muted">Select an attendance date.</span>'); return; }

                    $result.html('<span class="text-muted"><i class="fa fa-spinner fa-spin"></i> Checking schedule...</span>');

                    $.ajax({
                        url: '{{ route('teacher.attendance.check') }}',
                        type: 'GET',
                        data: { class_id: classId, section_id: sectionId, date: date },
                        success: function (response) {
                            if (response.has_classes) {
                                $('#loadStudentsBtn').prop('disabled', false);
                                if (response.has_timetable && response.has_students) {
                                    $result.html('<div class="alert alert-success" style="margin:0;">Students and timetable found. You can load students.</div>');
                                } else if (response.has_students) {
                                    $result.html('<div class="alert alert-info" style="margin:0;">Students found for this class/section. You can take attendance.</div>');
                                } else {
                                    $result.html('<div class="alert alert-success" style="margin:0;">Timetable found for this date. You can load students.</div>');
                                }
                            } else {
                                $result.html('<div class="alert alert-warning" style="margin:0;">No students found for this class, section, and date.</div>');
                            }
                        },
                        error: function () {
                            $result.html('<div class="alert alert-danger" style="margin:0;">Could not verify class schedule. Please try again.</div>');
                        }
                    });
                }

                $('#class_id').on('change', function () {
                    const classId = $(this).val();
                    const $section = $('#section_id');

                    $section.val('').empty().append('<option value="">Select Section</option>').prop('disabled', true);
                    $('#loadStudentsBtn').prop('disabled', true);
                    $('#attendanceSection').hide();

                    if (classId) {
                        $.ajax({
                            url: '{{ route('teacher.attendance.sections') }}',
                            type: 'GET',
                            data: { class_id: classId },
                            success: function (response) {
                                $section.empty().append('<option value="">Select Section</option>');
                                if (response.sections && response.sections.length > 0) {
                                    $.each(response.sections, function (i, s) {
                                        $section.append(`<option value="${s.id}">${s.name}</option>`);
                                    });
                                    $section.prop('disabled', false);
                                } else {
                                    showAlert('warning', 'No sections available for this class.');
                                }
                                refreshAttendanceAvailability();
                            },
                            error: function () { showAlert('danger', 'Failed to load sections.'); }
                        });
                    } else {
                        refreshAttendanceAvailability();
                    }
                });

                $('#section_id').on('change', function () { $('#attendanceSection').hide(); refreshAttendanceAvailability(); });
                $('#attendance_date').on('change', function () { $('#attendanceSection').hide(); refreshAttendanceAvailability(); });

                $('#loadStudentsBtn').click(function () {
                    const classId = $('#class_id').val();
                    const sectionId = $('#section_id').val();
                    const date = $('#attendance_date').val();
                    if (!classId || !sectionId || !date) { showAlert('danger', 'Please select class, section and date.'); return; }

                    $(this).html('<i class="fa fa-spinner fa-spin"></i> Loading...').prop('disabled', true);

                    $.ajax({
                        url: '{{ route('teacher.attendance.students') }}',
                        type: 'GET',
                        data: { class_id: classId, section_id: sectionId, date: date },
                        success: function (response) {
                            $('#loadStudentsBtn').html('<i class="fa fa-users"></i> Load Students').prop('disabled', false);

                            if (response.students.length > 0) {
                                $('#studentsList').empty();
                                let present = 0, absent = 0, late = 0;
                                $('#classSectionTitle').text(`${response.class.name} - ${response.section.name} (${date})`);

                                $.each(response.students, function (index, student) {
                                    const byUser = response.existingAttendance || {};
                                    const existing = byUser[student.student_id] || byUser[String(student.student_id)];
                                    const status = existing ? existing.status : '';
                                    const remarks = existing ? existing.remarks : '';

                                    if (status === 'present') present++;
                                    else if (status === 'absent') absent++;
                                    else if (status === 'late') late++;

                                    $('#studentsList').append(`
                                        <tr class="status-${status || 'undefined'}" data-student-id="${student.student_id}">
                                            <td>${index + 1}</td>
                                            <td><img src="${studentPhotoUrl(student.student?.profile_pic, student.photo_url)}" class="student-photo" onerror="this.src='${DEFAULT_PHOTO}'"></td>
                                            <td>${student.student ? student.student.name : ''}</td>
                                            <td>${student.admission_no || ''}</td>
                                            <td>
                                                <div class="btn-group" data-toggle="buttons">
                                                    <label class="btn btn-sm attendance-btn-present ${status === 'present' ? 'active' : ''}">
                                                        <input type="radio" name="attendance_${student.student_id}" value="present" ${status === 'present' ? 'checked' : ''}> Present
                                                    </label>
                                                    <label class="btn btn-sm attendance-btn-absent ${status === 'absent' ? 'active' : ''}">
                                                        <input type="radio" name="attendance_${student.student_id}" value="absent" ${status === 'absent' ? 'checked' : ''}> Absent
                                                    </label>
                                                    <label class="btn btn-sm attendance-btn-late ${status === 'late' ? 'active' : ''}">
                                                        <input type="radio" name="attendance_${student.student_id}" value="late" ${status === 'late' ? 'checked' : ''}> Late
                                                    </label>
                                                </div>
                                            </td>
                                            <td><input type="text" class="form-control input-sm remarks-input" placeholder="Remarks" value="${remarks || ''}"></td>
                                        </tr>
                                    `);
                                });

                                updateCounters(present, absent, late, response.students.length);
                                $('#attendanceSection').show();
                            } else {
                                showAlert('warning', 'No students found in this class/section.');
                                $('#attendanceSection').hide();
                            }
                        },
                        error: function (xhr) {
                            $('#loadStudentsBtn').html('<i class="fa fa-users"></i> Load Students').prop('disabled', false);
                            showAlert('danger', (xhr.responseJSON && xhr.responseJSON.message) || 'Failed to load students.');
                        }
                    });
                });

                $('body').on('click', '.bulk-action-btn', function () {
                    const status = $(this).data('status');
                    $('#studentsList tr').each(function () {
                        $(this).find(`input[type="radio"][value="${status}"]`).prop('checked', true);
                        $(this).find('.btn-group label').removeClass('active');
                        $(this).find(`input[type="radio"][value="${status}"]`).parent().addClass('active');
                        $(this).removeClass('status-present status-absent status-late status-undefined').addClass(`status-${status}`);
                    });
                    recountAllStatuses();
                });

                $('body').on('change', 'input[type="radio"][name^="attendance_"]', function () {
                    const status = $(this).val();
                    $(this).closest('tr').removeClass('status-present status-absent status-late status-undefined').addClass(`status-${status}`);
                    recountAllStatuses();
                });

                $('#saveAsDraftBtn').click(function () { saveAttendance('draft'); });
                $('#submitAttendanceBtn').click(function () { saveAttendance('submitted'); });

                function saveAttendance(status) {
                    const classId = $('#class_id').val();
                    const sectionId = $('#section_id').val();
                    const date = $('#attendance_date').val();
                    if (!classId || !sectionId || !date) { showAlert('danger', 'Please select class, section and date.'); return; }

                    const attendanceData = [];
                    $('#studentsList tr').each(function () {
                        attendanceData.push({
                            student_id: $(this).data('student-id'),
                            status: $(this).find('input[type="radio"]:checked').val() || '',
                            remarks: $(this).find('.remarks-input').val() || ''
                        });
                    });

                    const btn = status === 'draft' ? $('#saveAsDraftBtn') : $('#submitAttendanceBtn');
                    const originalText = btn.html();
                    btn.html('<i class="fa fa-spinner fa-spin"></i> Saving...').prop('disabled', true);

                    $.ajax({
                        url: '{{ route('teacher.attendance.store') }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            class_id: classId,
                            section_id: sectionId,
                            date: date,
                            status: status,
                            attendance: attendanceData
                        },
                        success: function (response) {
                            btn.html(originalText).prop('disabled', false);
                            showAlert('success', response.message);
                            setTimeout(function () { window.location.reload(); }, 900);
                        },
                        error: function (xhr) {
                            btn.html(originalText).prop('disabled', false);
                            showAlert('danger', (xhr.responseJSON && xhr.responseJSON.message) || 'Failed to save attendance.');
                        }
                    });
                }
            });
        </script>
    @endpush
</x-tenant-app-layout>
