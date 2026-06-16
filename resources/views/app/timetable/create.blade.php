<x-tenant-app-layout>
    @push('css')
        <link rel="stylesheet" href="{{ asset('backend/css/editor/select2.css') }}">
        <style>
            .hover-table tbody tr:hover td { background-color: #f5f5f5; }
            .period-group { border: 1px solid #e8e8e8; border-radius: 4px; padding: 12px 15px; margin-bottom: 15px; background: #fafafa; }
            .period-group h4 { margin-top: 0; display: inline-block; }
            #existingPeriodsSection { display: none; margin-bottom: 25px; }
            #existingPeriodsEmpty { display: none; }
            .existing-alert { margin-bottom: 15px; }
            .tt-existing-table td { vertical-align: middle !important; font-size: 13px; }
            .tt-existing-table .btn { margin: 1px; }
            .badge-break { background: #f0ad4e; }
            .badge-class { background: #3c8dbc; }
        </style>
    @endpush
    <x-slot name="header"></x-slot>

    <div class="container-fluid">
        <div class="row">

            <x-page-header title="Create Timetable" :back-route="route('admin.timetable.index')" />

            <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                <div class="sparkline12-list">
                    <div class="sparkline12-graph">
                        <div class="basic-login-form-ad">
                            <form id="timetableForm" method="POST" action="{{ route('admin.timetable.store') }}">
                                @csrf

                                <div class="section-headline"><h3>Basic Information</h3></div>

                                <div class="form-group-inner">
                                    <div class="row">
                                        <div class="col-lg-4"><label class="login2">Class*</label></div>
                                        <div class="col-lg-8">
                                            <select name="class_id" id="class_id" class="form-control" required>
                                                <option value="">Select Class</option>
                                                @foreach($classes as $class)
                                                    <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group-inner">
                                    <div class="row">
                                        <div class="col-lg-4"><label class="login2">Section*</label></div>
                                        <div class="col-lg-8">
                                            <select name="section_id" id="section_id" class="form-control" required disabled>
                                                <option value="">Select Class First</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                {{-- Existing periods --}}
                                <div id="existingPeriodsSection">
                                    <div class="section-headline" style="margin-top:20px;">
                                        <h3>Existing Periods <span id="existingCountBadge" class="badge badge-info">0</span></h3>
                                    </div>

                                    <div id="existingPeriodsAlert" class="alert alert-warning existing-alert">
                                        <i class="fa fa-info-circle"></i>
                                        This class and section already has a timetable. Review below — use <strong>Edit</strong> or <strong>Delete</strong>.
                                        New rows you add further down will be <em>added</em>, not replace these.
                                    </div>

                                    <div id="existingPeriodsEmpty" class="alert alert-success existing-alert">
                                        <i class="fa fa-check-circle"></i> No periods yet for this class and section. Add your first period below.
                                    </div>

                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped tt-existing-table" id="existingPeriodsTable">
                                            <thead style="background:#f5f5f5;">
                                                <tr>
                                                    <th>Day</th>
                                                    <th>Period</th>
                                                    <th>Time</th>
                                                    <th>Details</th>
                                                    <th>Room</th>
                                                    <th style="width:110px;">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody id="existingPeriodsBody"></tbody>
                                        </table>
                                    </div>
                                </div>

                                {{-- New periods --}}
                                <div class="section-headline" style="margin-top:20px;">
                                    <h3>Add New Periods</h3>
                                    <button type="button" id="addPeriod" class="btn btn-success btn-sm">
                                        <i class="fa fa-plus"></i> Add Period
                                    </button>
                                </div>

                                <p class="text-muted" style="font-size:13px;">
                                    Only the periods listed here will be created when you submit. Leave empty if you only edited existing periods above.
                                </p>

                                <div id="periodsContainer"></div>

                                <div class="form-group-inner" style="margin-top:15px;">
                                    <button type="submit" class="btn btn-primary" id="submitBtn">
                                        <i class="fa fa-save"></i> Add New Periods
                                    </button>
                                    <a href="{{ route('admin.timetable.index') }}" class="btn btn-default">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                <x-timetable-guide />
            </div>
        </div>
    </div>

    {{-- Edit existing period modal --}}
    <div class="modal fade" id="editPeriodModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit Period</h4>
                </div>
                <div class="modal-body">
                    <form id="editPeriodForm">
                        @csrf
                        <input type="hidden" name="entry_id" id="editEntryId">
                        <input type="hidden" name="class_id" id="editClassId">
                        <input type="hidden" name="section_id" id="editSectionId">
                        <input type="hidden" name="day" id="editDay">
                        <input type="hidden" name="period" id="editPeriodName">

                        <div class="form-group">
                            <label>Type</label>
                            <select class="form-control" name="type" id="editType">
                                <option value="class">Class</option>
                                <option value="event">Break / Event</option>
                            </select>
                        </div>

                        <div class="form-group edit-class-fields">
                            <label>Subject</label>
                            <select class="form-control" name="subject" id="editSubject" onchange="fetchEditTeachers(this)">
                                <option value="">Select Subject</option>
                            </select>
                        </div>

                        <div class="form-group edit-class-fields">
                            <label>Teacher</label>
                            <select class="form-control" name="teacher" id="editTeacher">
                                <option value="">Select Teacher</option>
                            </select>
                        </div>

                        <div class="form-group edit-event-fields" style="display:none;">
                            <label>Break / Event Name</label>
                            <input type="text" class="form-control" name="event" id="editEvent">
                        </div>

                        <div class="form-group">
                            <label>Start Time</label>
                            <input type="time" class="form-control" name="start" id="editStart" required>
                        </div>

                        <div class="form-group">
                            <label>End Time</label>
                            <input type="time" class="form-control" name="end" id="editEnd" required>
                        </div>

                        <div class="form-group">
                            <label>Room</label>
                            <input type="text" class="form-control" name="room" id="editRoom">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveEditPeriod">Save Changes</button>
                </div>
            </div>
        </div>
    </div>

    @push('js')
        <script>
            const classSubjects = @json($classSubjects);
            const sectionsUrl = @json(url('/get-sections'));
            const periodsUrl = @json(route('admin.timetable.periods'));
            const updateScheduleUrl = @json(route('admin.timetable.update.schedule'));
            const teachersUrl = @json(route('admin.getTeachersBySubject'));
            const csrfToken = @json(csrf_token());

            const destroyPeriodUrl = @json(route('admin.timetable.destroy', ['id' => '__ID__']));
            const sectionTeacherAssignUrl = @json(route('admin.academic.subjects.section_teacher'));
            const flashSuccess = @json(session('schedule_success'));
            const flashInfo = @json(session('schedule_info'));
            const flashError = @json(session('schedule_error'));

            let newPeriodIndex = 0;
            let existingPeriodsMap = {};

            function showToast(icon, title, timer) {
                if (typeof Swal === 'undefined') {
                    alert(title);
                    return;
                }

                Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: timer || 4500,
                    timerProgressBar: true,
                    didOpen: function (toast) {
                        toast.addEventListener('mouseenter', Swal.stopTimer);
                        toast.addEventListener('mouseleave', Swal.resumeTimer);
                    }
                }).fire({ icon: icon, title: title });
            }

            function showScheduleMessage(text) {
                var message = String(text || 'Something went wrong.').trim();
                var isAllocationError = message.indexOf('Section Teacher Allocation') !== -1;

                if (typeof Swal === 'undefined') {
                    alert(message);
                    return;
                }

                if (isAllocationError) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Teacher not allocated',
                        html: '<p style="margin:0 0 14px; color:#555; font-size:14px; line-height:1.5;">' + message + '</p>' +
                              '<a href="' + sectionTeacherAssignUrl + '" class="btn btn-success btn-sm">' +
                              '<i class="fa fa-user-plus"></i> Open Section Teacher Allocation</a>',
                        confirmButtonText: 'Close',
                        confirmButtonColor: '#6366f1',
                    });
                    return;
                }

                showToast('error', message, 6000);
            }

            function showScheduleError(xhr) {
                var messages = ['Error saving schedule. Please try again.'];

                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    messages = Object.values(xhr.responseJSON.errors).flat();
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    messages = [xhr.responseJSON.message];
                }

                showScheduleMessage(messages.join(' '));
            }

            function populateSubjectSelect($select, classId, selectedId) {
                let options = '<option value="">Select Subject</option>';
                if (!classId) {
                    $select.html('<option value="">Select Class First</option>');
                    return;
                }
                const subjects = classSubjects[classId] || [];
                if (!subjects.length) {
                    $select.html('<option value="">No subjects for this class</option>');
                    return;
                }
                subjects.forEach(function (s) {
                    const sel = (selectedId && s.id == selectedId) ? ' selected' : '';
                    options += `<option value="${s.id}"${sel}>${s.name} (${s.code})</option>`;
                });
                $select.html(options);
            }

            function loadSections(classId, selectedSectionId) {
                const $section = $('#section_id');
                if (!classId) {
                    $section.html('<option value="">Select Class First</option>').prop('disabled', true);
                    hideExistingPeriods();
                    return;
                }
                $section.prop('disabled', true).html('<option value="">Loading...</option>');
                $.get(sectionsUrl + '/' + classId, function (response) {
                    let options = '<option value="">Select Section</option>';
                    if (response && Object.keys(response).length) {
                        $.each(response, function (id, name) {
                            const sel = (selectedSectionId && id == selectedSectionId) ? ' selected' : '';
                            options += `<option value="${id}"${sel}>${name}</option>`;
                        });
                    } else {
                        options = '<option value="">No sections available</option>';
                    }
                    $section.html(options).prop('disabled', false);
                    if (selectedSectionId) {
                        loadExistingPeriods();
                    }
                }).fail(function () {
                    $section.html('<option value="">Error loading sections</option>').prop('disabled', false);
                });
            }

            function hideExistingPeriods() {
                $('#existingPeriodsSection').hide();
                $('#existingPeriodsBody').empty();
            }

            function loadExistingPeriods() {
                const classId = $('#class_id').val();
                const sectionId = $('#section_id').val();
                if (!classId || !sectionId) {
                    hideExistingPeriods();
                    return;
                }

                $('#existingPeriodsSection').show();
                $('#existingPeriodsBody').html('<tr><td colspan="6" class="text-center text-muted">Loading...</td></tr>');

                $.get(periodsUrl, { class_id: classId, section_id: sectionId }, function (res) {
                    renderExistingPeriods(res.periods || [], res.count || 0);
                }).fail(function () {
                    $('#existingPeriodsBody').html('<tr><td colspan="6" class="text-danger text-center">Failed to load periods.</td></tr>');
                });
            }

            function renderExistingPeriods(periods, count) {
                existingPeriodsMap = {};
                $('#existingCountBadge').text(count);
                if (count === 0) {
                    $('#existingPeriodsAlert').hide();
                    $('#existingPeriodsEmpty').show();
                    $('#existingPeriodsTable').hide();
                    $('#existingPeriodsBody').empty();
                    return;
                }

                $('#existingPeriodsAlert').show();
                $('#existingPeriodsEmpty').hide();
                $('#existingPeriodsTable').show();

                let rows = '';
                periods.forEach(function (p) {
                    existingPeriodsMap[p.id] = p;
                    const details = p.is_break
                        ? `<span class="badge badge-break">Break</span> ${escapeHtml(p.break_name || '—')}`
                        : `<span class="badge badge-class">${escapeHtml(p.subject_name || '—')}</span><br><small><i class="fa fa-user"></i> ${escapeHtml(p.teacher_name || '—')}</small>`;

                    rows += `<tr data-period-id="${p.id}">
                        <td>${escapeHtml(p.day)}</td>
                        <td>${escapeHtml(p.period_name)}</td>
                        <td>${escapeHtml(p.start_time)} – ${escapeHtml(p.end_time)}</td>
                        <td>${details}</td>
                        <td>${escapeHtml(p.room_number || '—')}</td>
                        <td>
                            <button type="button" class="btn btn-primary btn-xs btn-edit-period" data-id="${p.id}">
                                <i class="fa fa-pencil"></i>
                            </button>
                            <button type="button" class="btn btn-danger btn-xs btn-delete-period" data-id="${p.id}">
                                <i class="fa fa-trash"></i>
                            </button>
                        </td>
                    </tr>`;
                });
                $('#existingPeriodsBody').html(rows);
            }

            function escapeHtml(str) {
                if (str == null) return '';
                return String(str).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
            }

            function addNewPeriodRow() {
                const idx = newPeriodIndex++;
                const periodId = 'period_' + idx;
                const html = `
                <div class="period-group" id="${periodId}">
                    <h4>New Period #${idx + 1}</h4>
                    <button type="button" class="btn btn-danger btn-xs remove-period" data-period="${periodId}">
                        <i class="fa fa-trash"></i> Remove
                    </button>
                    <div class="form-group-inner" style="margin-top:10px;">
                        <div class="row">
                            <div class="col-lg-4"><label class="login2">Day*</label></div>
                            <div class="col-lg-8">
                                <select name="periods[${idx}][day]" class="form-control" required>
                                    ${['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'].map(d => `<option value="${d}">${d}</option>`).join('')}
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group-inner">
                        <div class="row">
                            <div class="col-lg-4"><label class="login2">Period Name*</label></div>
                            <div class="col-lg-8">
                                <input type="text" name="periods[${idx}][period_name]" class="form-control" placeholder="e.g. First Period" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group-inner">
                        <div class="row">
                            <div class="col-lg-4"><label class="login2">Start Time*</label></div>
                            <div class="col-lg-8">
                                <input type="time" name="periods[${idx}][start_time]" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group-inner">
                        <div class="row">
                            <div class="col-lg-4"><label class="login2">End Time*</label></div>
                            <div class="col-lg-8">
                                <input type="time" name="periods[${idx}][end_time]" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group-inner">
                        <div class="row">
                            <div class="col-lg-4"><label class="login2">Is Break?</label></div>
                            <div class="col-lg-8">
                                <input type="checkbox" name="periods[${idx}][is_break]" class="is-break-checkbox" value="1">
                            </div>
                        </div>
                    </div>
                    <div class="break-fields" style="display:none;">
                        <div class="form-group-inner">
                            <div class="row">
                                <div class="col-lg-4"><label class="login2">Break Name</label></div>
                                <div class="col-lg-8">
                                    <input type="text" name="periods[${idx}][break_name]" class="form-control" placeholder="e.g. Lunch Break">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="subject-fields">
                        <div class="form-group-inner">
                            <div class="row">
                                <div class="col-lg-4"><label class="login2">Subject</label></div>
                                <div class="col-lg-8">
                                    <select name="periods[${idx}][subject_id]" class="form-control subject-select" data-idx="${idx}">
                                        <option value="">Select Subject</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group-inner">
                            <div class="row">
                                <div class="col-lg-4"><label class="login2">Teacher</label></div>
                                <div class="col-lg-8">
                                    <select name="periods[${idx}][teacher_id]" class="form-control teacher-select" id="teacher-select-${idx}">
                                        <option value="">Select Teacher</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group-inner">
                        <div class="row">
                            <div class="col-lg-4"><label class="login2">Room</label></div>
                            <div class="col-lg-8">
                                <input type="text" name="periods[${idx}][room_number]" class="form-control" placeholder="e.g. Room 101">
                            </div>
                        </div>
                    </div>
                </div>`;
                $('#periodsContainer').append(html);
                populateSubjectSelect($('#' + periodId).find('.subject-select'), $('#class_id').val());
            }

            function fetchTeachersForNewPeriod(selectEl) {
                const subjectId = selectEl.value;
                const classId = $('#class_id').val();
                const idx = $(selectEl).data('idx');
                const $teacher = $('#teacher-select-' + idx);
                if (!subjectId || !classId) {
                    $teacher.html('<option value="">Select Subject First</option>');
                    return;
                }
                $.get(teachersUrl, {
                    subject_id: subjectId,
                    class_id: classId,
                    section_id: $('#section_id').val()
                }, function (res) {
                    let opts = '<option value="">Select Teacher</option>';
                    (res.teachers || []).forEach(function (t) {
                        const sel = (res.assigned_teacher_id && t.id == res.assigned_teacher_id) ? ' selected' : '';
                        opts += `<option value="${t.id}"${sel}>${t.name}</option>`;
                    });
                    if (!(res.teachers || []).length) {
                        opts += '<option value="" disabled>No qualified teachers — assign under Teacher Capabilities</option>';
                    }
                    $teacher.html(opts);
                });
            }

            function toggleEditTypeFields() {
                if ($('#editType').val() === 'event') {
                    $('.edit-class-fields').hide();
                    $('.edit-event-fields').show();
                } else {
                    $('.edit-class-fields').show();
                    $('.edit-event-fields').hide();
                }
            }

            function fetchEditTeachers(selectEl) {
                const subjectId = selectEl.value;
                const classId = $('#editClassId').val();
                const $teacher = $('#editTeacher');
                if (!subjectId || !classId) {
                    $teacher.html('<option value="">Select Subject First</option>');
                    return;
                }
                $.get(teachersUrl, {
                    subject_id: subjectId,
                    class_id: classId,
                    section_id: $('#editSectionId').val()
                }, function (res) {
                    let opts = '<option value="">Select Teacher</option>';
                    (res.teachers || []).forEach(function (t) {
                        opts += `<option value="${t.id}">${t.name}</option>`;
                    });
                    $teacher.html(opts);
                    const current = $('#editPeriodForm').data('teacher-id');
                    if (current) $teacher.val(current);
                });
            }

            function openEditModal(period) {
                $('#editEntryId').val(period.id);
                $('#editClassId').val($('#class_id').val());
                $('#editSectionId').val($('#section_id').val());
                $('#editDay').val(period.day);
                $('#editPeriodName').val(period.period_name);
                $('#editStart').val(period.start_time);
                $('#editEnd').val(period.end_time);
                $('#editRoom').val(period.room_number || '');
                $('#editPeriodForm').data('teacher-id', period.teacher_id);

                if (period.is_break) {
                    $('#editType').val('event');
                    $('#editEvent').val(period.break_name || '');
                } else {
                    $('#editType').val('class');
                    $('#editEvent').val('');
                }
                toggleEditTypeFields();

                populateSubjectSelect($('#editSubject'), $('#class_id').val(), period.subject_id);
                if (period.subject_id) {
                    fetchEditTeachers(document.getElementById('editSubject'));
                } else {
                    $('#editTeacher').html('<option value="">Select Teacher</option>');
                }

                $('#editPeriodModal').modal('show');
            }

            $(document).ready(function () {
                if (flashSuccess) showToast('success', flashSuccess);
                if (flashInfo) showToast('info', flashInfo);
                if (flashError) showScheduleMessage(flashError);

                const oldClass = @json(old('class_id'));
                const oldSection = @json(old('section_id'));
                if (oldClass) {
                    loadSections(oldClass, oldSection);
                }

                $('#class_id').on('change', function () {
                    $('#periodsContainer').empty();
                    newPeriodIndex = 0;
                    loadSections($(this).val(), null);
                });

                $('#section_id').on('change', function () {
                    $('#periodsContainer').empty();
                    newPeriodIndex = 0;
                    loadExistingPeriods();
                });

                $('#addPeriod').on('click', addNewPeriodRow);

                $(document).on('click', '.remove-period', function () {
                    $('#' + $(this).data('period')).remove();
                });

                $(document).on('change', '.is-break-checkbox', function () {
                    const $g = $(this).closest('.period-group');
                    if ($(this).is(':checked')) {
                        $g.find('.break-fields').show();
                        $g.find('.subject-fields').hide();
                    } else {
                        $g.find('.break-fields').hide();
                        $g.find('.subject-fields').show();
                    }
                });

                $(document).on('change', '.subject-select', function () {
                    fetchTeachersForNewPeriod(this);
                });

                $(document).on('click', '.btn-edit-period', function () {
                    const period = existingPeriodsMap[$(this).data('id')];
                    if (period) openEditModal(period);
                });

                $(document).on('click', '.btn-delete-period', function () {
                    const id = $(this).data('id');

                    const runDelete = function () {
                        $.ajax({
                            url: destroyPeriodUrl.replace('__ID__', id),
                            method: 'POST',
                            data: { _token: csrfToken, _method: 'DELETE' },
                            success: function () {
                                showToast('success', 'Period deleted successfully.');
                                loadExistingPeriods();
                            },
                            error: showScheduleError
                        });
                    };

                    if (typeof Swal === 'undefined') {
                        if (confirm('Delete this period? This cannot be undone.')) runDelete();
                        return;
                    }

                    Swal.fire({
                        icon: 'warning',
                        title: 'Delete period?',
                        text: 'This cannot be undone.',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Yes, delete',
                        cancelButtonText: 'Cancel',
                    }).then(function (result) {
                        if (result.isConfirmed) runDelete();
                    });
                });

                $('#editType').on('change', toggleEditTypeFields);

                $('#saveEditPeriod').on('click', function () {
                    $.post(updateScheduleUrl, $('#editPeriodForm').serialize())
                        .done(function () {
                            $('#editPeriodModal').modal('hide');
                            showToast('success', 'Period updated successfully.');
                            loadExistingPeriods();
                        })
                        .fail(showScheduleError);
                });

                $('#timetableForm').on('submit', function (e) {
                    const newCount = $('.period-group').length;
                    if (newCount === 0) {
                        e.preventDefault();
                        showToast('warning', 'Add at least one new period below, or use Edit / Delete on existing periods above.');
                        return false;
                    }

                    const timeSlots = {};
                    let hasError = false;
                    $('.period-group').each(function () {
                        const day = $(this).find('[name*="[day]"]').val();
                        const start = $(this).find('[name*="[start_time]"]').val();
                        const key = $('#class_id').val() + '-' + $('#section_id').val() + '-' + day + '-' + start;
                        if (timeSlots[key]) {
                            showToast('warning', 'Duplicate time slot in new periods: ' + day + ' at ' + start);
                            hasError = true;
                            return false;
                        }
                        timeSlots[key] = true;
                    });
                    if (hasError) {
                        e.preventDefault();
                        return false;
                    }
                });
            });
        </script>
    @endpush
</x-tenant-app-layout>
