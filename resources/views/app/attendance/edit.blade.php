<x-tenant-app-layout>
    @push('css')
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
            .attendance-btn-present.active,
            .attendance-btn-present:active {
                background-color: #3c763d !important;
                color: #fff !important;
                border-color: #3c763d !important;
            }
            .attendance-btn-absent.active,
            .attendance-btn-absent:active {
                background-color: #a94442 !important;
                color: #fff !important;
                border-color: #a94442 !important;
            }
            .attendance-btn-late.active,
            .attendance-btn-late:active {
                background-color: #f0ad4e !important;
                color: #333 !important;
                border-color: #eea236 !important;
            }
            .session-info-box {
                background: #f8f9fa;
                border: 1px solid #e9ecef;
                border-radius: 4px;
                padding: 15px;
                margin-bottom: 20px;
            }
        </style>
    @endpush

    <x-slot name="header"></x-slot>

    @php
        $className = $session->timeTable->class->name ?? $session->schoolClass?->name ?? 'N/A';
        $sectionName = $session->timeTable->section->name ?? $session->section?->name ?? 'N/A';
    @endphp

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcome-list">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="breadcome-heading" style="margin-top: 10px">
                                <h3>Edit Attendance</h3>
                            </div>
                        </div>
                        <div class="col-lg-6 text-right">
                            <a href="{{ route('admin.attendance.show', $session->id) }}" class="btn btn-default btn-sm">
                                <i class="fa fa-eye"></i> View
                            </a>
                            <a href="{{ route('admin.attendance.index') }}" class="btn btn-primary btn-sm" style="color: white">
                                <i class="fa fa-arrow-left"></i> Back
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="session-info-box">
                    <div class="row">
                        <div class="col-md-3">
                            <strong>Date:</strong> {{ \Carbon\Carbon::parse($session->date)->format('d M Y') }}
                        </div>
                        <div class="col-md-3">
                            <strong>Class:</strong> {{ $className }}
                        </div>
                        <div class="col-md-3">
                            <strong>Section:</strong> {{ $sectionName }}
                        </div>
                        <div class="col-md-3">
                            <strong>Status:</strong>
                            @if(($session->status ?? 'draft') === 'submitted')
                                <span class="label label-success">Submitted</span>
                            @else
                                <span class="label label-warning">Draft</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="sparkline13-list">
                    <div class="sparkline13-graph">
                        <div class="basic-login-form-ad">
                            <input type="hidden" id="session_id" value="{{ $session->id }}">
                            <div class="form-section">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h3>Mark Attendance for {{ $className }} - {{ $sectionName }}</h3>
                                    <div class="bulk-actions">
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
                                    <table class="table table-bordered table-hover">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>#</th>
                                                <th>Photo</th>
                                                <th>Student Name</th>
                                                <th>Admission No.</th>
                                                <th>Status</th>
                                                <th>Remarks</th>
                                            </tr>
                                        </thead>
                                        <tbody id="studentsList">
                                            @foreach($students as $index => $student)
                                                @php
                                                    $existing = $existingAttendance->get($student->student_id);
                                                    $status = $existing?->status ?? '';
                                                    $remarks = $existing?->remarks ?? '';
                                                @endphp
                                                <tr class="status-{{ $status ?: 'undefined' }}" data-student-id="{{ $student->student_id }}">
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>
                                                        <img src="{{ $student->photo_url }}"
                                                             alt="{{ $student->student?->name }}"
                                                             class="student-photo"
                                                             onerror="this.src='{{ asset('backend/img/profile/1.jpg') }}'">
                                                    </td>
                                                    <td>{{ $student->student?->name ?? 'N/A' }}</td>
                                                    <td>{{ $student->admission_no }}</td>
                                                    <td>
                                                        <div class="btn-group" data-toggle="buttons">
                                                            <label class="btn btn-sm attendance-btn-present {{ $status === 'present' ? 'active' : '' }}">
                                                                <input type="radio" name="attendance_{{ $student->student_id }}"
                                                                    value="present" {{ $status === 'present' ? 'checked' : '' }}> Present
                                                            </label>
                                                            <label class="btn btn-sm attendance-btn-absent {{ $status === 'absent' ? 'active' : '' }}">
                                                                <input type="radio" name="attendance_{{ $student->student_id }}"
                                                                    value="absent" {{ $status === 'absent' ? 'checked' : '' }}> Absent
                                                            </label>
                                                            <label class="btn btn-sm attendance-btn-late {{ $status === 'late' ? 'active' : '' }}">
                                                                <input type="radio" name="attendance_{{ $student->student_id }}"
                                                                    value="late" {{ $status === 'late' ? 'checked' : '' }}> Late
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="remarks-text">{{ $remarks }}</span>
                                                        <button type="button" class="btn btn-sm btn-outline-primary add-remarks-btn pull-right"
                                                                data-student-id="{{ $student->student_id }}">
                                                            <i class="fa fa-comment"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="attendance-actions">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="attendance-stats">
                                            <span class="badge badge-success">Present: <span id="presentCount">0</span></span>
                                            <span class="badge badge-danger ml-2">Absent: <span id="absentCount">0</span></span>
                                            <span class="badge badge-warning ml-2">Late: <span id="lateCount">0</span></span>
                                            <span class="badge badge-info ml-2">Total: <span id="totalCount">0</span></span>
                                        </div>
                                        <div class="action-buttons">
                                            <button type="button" id="saveAsDraftBtn" class="btn btn-secondary">
                                                <i class="fa fa-save"></i> Save as Draft
                                            </button>
                                            <button type="button" id="submitAttendanceBtn" class="btn btn-primary ml-2">
                                                <i class="fa fa-check-circle"></i> Submit Attendance
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="remarksModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Remarks</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="remarksStudentId">
                    <div class="form-group">
                        <label for="remarksText">Remarks</label>
                        <textarea class="form-control" id="remarksText" rows="3" placeholder="Enter remarks"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="leaveType">Leave Type (if absent)</label>
                        <select class="form-control" id="leaveType">
                            <option value="">Not Applicable</option>
                            <option value="sick">Sick Leave</option>
                            <option value="casual">Casual Leave</option>
                            <option value="emergency">Family Emergency</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveRemarksBtn">Save Remarks</button>
                </div>
            </div>
        </div>
    </div>

    @push('js')
        <script>
            function showAlert(type, message) {
                $('.alert-notification').remove();
                const alertHtml = `
                    <div class="alert alert-${type} alert-dismissible fade show alert-notification">
                        ${message}
                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                    </div>
                `;
                $('body').append(alertHtml);
                setTimeout(() => $('.alert-notification').alert('close'), 5000);
            }

            function recountAllStatuses() {
                let presentCount = 0, absentCount = 0, lateCount = 0;
                $('#studentsList tr').each(function() {
                    const status = $(this).find('input[type="radio"]:checked').val();
                    if (status === 'present') presentCount++;
                    else if (status === 'absent') absentCount++;
                    else if (status === 'late') lateCount++;
                });
                updateCounters(presentCount, absentCount, lateCount, $('#studentsList tr').length);
            }

            function updateCounters(present, absent, late, total) {
                $('#presentCount').text(present);
                $('#absentCount').text(absent);
                $('#lateCount').text(late);
                $('#totalCount').text(total);
            }

            $(document).ready(function() {
                recountAllStatuses();

                $('body').on('click', '.bulk-action-btn', function() {
                    const status = $(this).data('status');
                    $(`#studentsList input[type="radio"][value="${status}"]`).prop('checked', true).trigger('change');
                    $('#studentsList tr').removeClass('status-present status-absent status-late status-undefined')
                        .addClass('status-' + status);
                    $('#studentsList .attendance-btn-present, #studentsList .attendance-btn-absent, #studentsList .attendance-btn-late')
                        .removeClass('active');
                    $(`#studentsList input[type="radio"][value="${status}"]:checked`).each(function() {
                        $(this).closest('label').addClass('active');
                    });
                    recountAllStatuses();
                });

                $('body').on('change', '#studentsList input[type="radio"]', function() {
                    const status = $(this).val();
                    const $row = $(this).closest('tr');
                    $row.removeClass('status-present status-absent status-late status-undefined')
                        .addClass('status-' + status);
                    $row.find('.attendance-btn-present, .attendance-btn-absent, .attendance-btn-late').removeClass('active');
                    $(this).closest('label').addClass('active');
                    recountAllStatuses();
                });

                $('body').on('click', '.add-remarks-btn', function() {
                    const studentId = $(this).data('student-id');
                    $('#remarksStudentId').val(studentId);
                    $('#remarksText').val($(this).siblings('.remarks-text').text());
                    $('#remarksModal').modal('show');
                });

                $('#saveRemarksBtn').click(function() {
                    const studentId = $('#remarksStudentId').val();
                    const remarks = $('#remarksText').val();
                    const leaveType = $('#leaveType').val();
                    const $row = $(`tr[data-student-id="${studentId}"]`);
                    $row.find('.remarks-text').text(remarks);

                    if ($row.find('input[value="absent"]:checked').length > 0 && leaveType) {
                        const leaveTypeText = '[Leave Type: ' + $('#leaveType option:selected').text() + ']';
                        const current = $row.find('.remarks-text').text();
                        $row.find('.remarks-text').text(current ? current + ' ' + leaveTypeText : leaveTypeText);
                    }
                    $('#remarksModal').modal('hide');
                });

                $('#saveAsDraftBtn').click(() => saveAttendance('draft'));
                $('#submitAttendanceBtn').click(() => saveAttendance('submitted'));

                function saveAttendance(status) {
                    const sessionId = $('#session_id').val();
                    const attendanceData = [];

                    $('#studentsList tr').each(function() {
                        attendanceData.push({
                            student_id: $(this).data('student-id'),
                            status: $(this).find('input[type="radio"]:checked').val() || '',
                            remarks: $(this).find('.remarks-text').text()
                        });
                    });

                    const btn = status === 'draft' ? $('#saveAsDraftBtn') : $('#submitAttendanceBtn');
                    const originalText = btn.html();
                    btn.html('<i class="fa fa-spinner fa-spin"></i> Saving...').prop('disabled', true);

                    $.ajax({
                        url: '{{ route('admin.attendance.update', $session->id) }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            _method: 'PUT',
                            status: status,
                            attendance: attendanceData
                        },
                        success: function(response) {
                            btn.html(originalText).prop('disabled', false);
                            showAlert('success', response.message);
                            if (status === 'submitted') {
                                window.location.href = '{{ route('admin.attendance.index') }}';
                            }
                        },
                        error: function(xhr) {
                            btn.html(originalText).prop('disabled', false);
                            showAlert('danger', xhr.responseJSON?.message || 'Failed to update attendance');
                        }
                    });
                }
            });
        </script>
    @endpush
</x-tenant-app-layout>
