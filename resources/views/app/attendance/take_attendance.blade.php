<x-tenant-app-layout>
    @push('css')
        <!-- Bootstrap CSS ============================================ -->
        <link rel="stylesheet" href="{{ asset('backend/css/bootstrap.min.css') }}">
        <!-- Bootstrap CSS ============================================ -->
        <link rel="stylesheet" href="{{ asset('backend/css/font-awesome.min.css') }}">
        <!-- owl.carousel CSS ============================================ -->
        <link rel="stylesheet" href="{{ asset('backend/css/owl.carousel.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/owl.theme.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/owl.transitions.css') }}">
        <!-- animate CSS ============================================ -->
        <link rel="stylesheet" href="{{ asset('backend/css/animate.css') }}">
        <!-- normalize CSS ============================================ -->
        <link rel="stylesheet" href="{{ asset('backend/css/normalize.css') }}">
        <!-- meanmenu icon CSS ============================================ -->
        <link rel="stylesheet" href="{{ asset('backend/css/meanmenu.min.css') }}">
        <!-- main CSS ============================================ -->
        <link rel="stylesheet" href="{{ asset('backend/css/main.css') }}">
        <!-- educate icon CSS ============================================ -->
        <link rel="stylesheet" href="{{ asset('backend/css/educate-custon-icon.css') }}">
        <!-- morrisjs CSS ============================================ -->
        <link rel="stylesheet" href="{{ asset('backend/css/morrisjs/morris.css') }}">
        <!-- mCustomScrollbar CSS ============================================ -->
        <link rel="stylesheet" href="{{ asset('backend/css/scrollbar/jquery.mCustomScrollbar.min.css') }}">
        <!-- metisMenu CSS ============================================ -->
        <link rel="stylesheet" href="{{ asset('backend/css/metisMenu/metisMenu.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/metisMenu/metisMenu-vertical.css') }}">
        <!-- calendar CSS ============================================ -->
        <link rel="stylesheet" href="{{ asset('backend/css/calendar/fullcalendar.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/calendar/fullcalendar.print.min.css') }}">
        <!-- x-editor CSS ============================================ -->
        <link rel="stylesheet" href="{{ asset('backend/css/editor/select2.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/editor/datetimepicker.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/editor/bootstrap-editable.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/editor/x-editor-style.css') }}">
        <!-- normalize CSS ============================================ -->
        <link rel="stylesheet" href="{{ asset('backend/css/data-table/bootstrap-table.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/data-table/bootstrap-editable.css') }}">
        <!-- style CSS ============================================ -->
        <link rel="stylesheet" href="{{ asset('backend/style.css') }}">
        <!-- responsive CSS ============================================ -->
        <link rel="stylesheet" href="{{ asset('backend/css/responsive.css') }}">
        <!-- modernizr JS ============================================ -->
        <script src="{{ asset('backend/js/vendor/modernizr-2.8.3.min.js') }}"></script>
    @endpush
    
    @push('css')
    <!-- Add select2 for better dropdowns -->
    <link rel="stylesheet" href="{{ asset('backend/css/select2/select2.min.css') }}">
    <style>
        .alert-notification {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            min-width: 300px;
        }
        .attendance-status-btn {
            min-width: 80px;
        }
        .student-photo {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }
        .status-present {
            background-color: #d4edda;
        }
        .status-absent {
            background-color: #f8d7da;
        }
        .status-late {
            background-color: #fff3cd;
        }
        .status-undefined {
            background-color: #e2e3e5;
        }
        .attendance-actions {
            position: sticky;
            bottom: 0;
            background: white;
            padding: 15px;
            border-top: 1px solid #eee;
            box-shadow: 0 -2px 10px rgba(0,0,0,0.05);
        }
    </style>

    @endpush
    <x-slot name="header"></x-slot>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="breadcome-list">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="breadcome-heading" style="margin-top: 10px">
                                <h3>Take Attendance</h3>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <ul class="breadcome-menu">
                                <li>
                                    <a href="{{ route('dashboard.add.teacher') }}" class="btn btn-primary btn-sm" style="color: white">
                                        <i class="fa fa-user-plus"></i> Add Teacher
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="sparkline12-list">
                    <div class="sparkline12-graph">
                        <div class="basic-login-form-ad">
                            <form id="attendanceForm" method="POST">
                                @csrf
                                <div class="form-section">
                                    <h3>Attendance Selection</h3>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Class *</label>
                                                <select class="form-control select2" id="class_id" name="class_id" required>
                                                    <option value="">Select Class</option>
                                                    @foreach($classes as $class)
                                                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Section *</label>
                                                <select class="form-control select2" id="section_id" name="section_id" required disabled>
                                                    <option value="">Select Section</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Date *</label>
                                                <input type="date" class="form-control" id="attendance_date" name="date" 
                                                    value="" max="{{ date('Y-m-d') }}" required>
                                                <div id="class_check_result" class="mt-2"></div>
                                            </div>
                                        </div>                                       
                                    </div>
                                    <div class="text-right">
                                        <button type="button" id="loadStudentsBtn" class="btn btn-primary" disabled>
                                            <i class="fa fa-users"></i> Load Students
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Attendance Table Section (hidden initially) -->
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="attendanceSection" style="display: none;">
                <div class="sparkline13-list">
                    <div class="sparkline13-graph">
                        <div class="basic-login-form-ad">
                            <div class="form-section">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h3>Mark Attendance for <span id="classSectionTitle"></span></h3>
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
                                    <table class="table table-bordered table-hover" id="attendanceTable">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>#</th>
                                                <th>Photo</th>
                                                <th>Student Name</th>
                                                <th>Admission No.</th>
                                                <th>Status</th>
                                                <th>Remarks</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="studentsList">
                                            <!-- Students will be loaded here via AJAX -->
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

    <!-- Remarks Modal -->
    <div class="modal fade" id="remarksModal" tabindex="-1" role="dialog" aria-labelledby="remarksModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="remarksModalLabel">Add Remarks</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="remarksStudentId">
                    <div class="form-group">
                        <label for="remarksText">Remarks</label>
                        <textarea class="form-control" id="remarksText" rows="3" placeholder="Enter remarks (e.g., reason for absence)"></textarea>
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
       <!-- jquery ============================================ -->
    <script src="{{ asset('backend/js/vendor/jquery-1.12.4.min.js') }}"></script>
    <!-- bootstrap JS ============================================ -->
    <script src="{{ asset('backend/js/bootstrap.min.js') }}"></script>
    <!-- wow JS ============================================ -->
    <script src="{{ asset('backend/js/wow.min.js') }}"></script>
    <!-- price-slider JS ============================================ -->
    <script src="{{ asset('backend/js/jquery-price-slider.js') }}"></script>
    <!-- meanmenu JS ============================================ -->
    <script src="{{ asset('backend/js/jquery.meanmenu.js') }}"></script>
    <!-- owl.carousel JS ============================================ -->
    <script src="{{ asset('backend/js/owl.carousel.min.js') }}"></script>
    <!-- sticky JS ============================================ -->
    <script src="{{ asset('backend/js/jquery.sticky.js') }}"></script>
    <!-- scrollUp JS ============================================ -->
    <script src="{{ asset('backend/js/jquery.scrollUp.min.js') }}"></script>
    <!-- mCustomScrollbar JS ============================================ -->
    <script src="{{ asset('backend/js/scrollbar/jquery.mCustomScrollbar.concat.min.js') }}"></script>
    <script src="{{ asset('backend/js/scrollbar/mCustomScrollbar-active.js') }}"></script>
    <!-- metisMenu JS ============================================ -->
    <script src="{{ asset('backend/js/metisMenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('backend/js/metisMenu/metisMenu-active.js') }}"></script>
    <!-- data table JS ============================================ -->
    <script src="{{ asset('backend/js/data-table/bootstrap-table.js') }}"></script>
    <script src="{{ asset('backend/js/data-table/tableExport.js') }}"></script>
    <script src="{{ asset('backend/js/data-table/data-table-active.js') }}"></script>
    <script src="{{ asset('backend/js/data-table/bootstrap-table-editable.js') }}"></script>
    <script src="{{ asset('backend/js/data-table/bootstrap-editable.js') }}"></script>
    <script src="{{ asset('backend/js/data-table/bootstrap-table-resizable.js') }}"></script>
    <script src="{{ asset('backend/js/data-table/colResizable-1.5.source.js') }}"></script>
    <script src="{{ asset('backend/js/data-table/bootstrap-table-export.js') }}"></script>
    <!--  editable JS ============================================ -->
    <script src="{{ asset('backend/js/editable/jquery.mockjax.js') }}"></script>
    <script src="{{ asset('backend/js/editable/mock-active.js') }}"></script>
    <script src="{{ asset('backend/js/editable/select2.js') }}"></script>
    <script src="{{ asset('backend/js/editable/moment.min.js') }}"></script>
    <script src="{{ asset('backend/js/editable/bootstrap-datetimepicker.js') }}"></script>
    <script src="{{ asset('backend/js/editable/bootstrap-editable.js') }}"></script>
    <script src="{{ asset('backend/js/editable/xediable-active.js') }}"></script>
    <!-- Chart JS ============================================ -->
    <script src="{{ asset('backend/js/chart/jquery.peity.min.js') }}"></script>
    <script src="{{ asset('backend/js/peity/peity-active.js') }}"></script>
    <!-- tab JS ============================================ -->
    <script src="{{ asset('backend/js/tab.js') }}"></script>
    <!-- plugins JS ============================================ -->
    <script src="{{ asset('backend/js/plugins.js') }}"></script>
    <!-- main JS ============================================ -->
    <script src="{{ asset('backend/js/main.js') }}"></script>
    @endpush
    
    @push('js')
        <!-- Add select2 for better dropdowns -->
        <script src="{{ asset('backend/js/select2/select2.full.min.js') }}"></script>
        
            
            <script>
                // Notification system using Bootstrap alerts
                function showAlert(type, message) {
                    // Remove any existing alerts first
                    $('.alert-notification').remove();
                    
                    const alertHtml = `
                        <div class="alert alert-${type} alert-dismissible fade show alert-notification">
                            ${message}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    `;
                    
                    $('body').append(alertHtml);
                    
                    // Auto-remove after 5 seconds
                    setTimeout(() => {
                        $('.alert-notification').alert('close');
                    }, 5000);
                }

                $(document).ready(function() {
                    // Initialize select2
                    $('.select2').select2();
                    
                    // Notification system using Bootstrap alerts
                    function showAlert(type, message) {
                        $('.alert-notification').remove();
                        const alertHtml = `
                            <div class="alert alert-${type} alert-dismissible fade show alert-notification">
                                ${message}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        `;
                        $('body').append(alertHtml);
                        setTimeout(() => {
                            $('.alert-notification').alert('close');
                        }, 5000);
                    }

                    // Function to update counters
                    function updateCounters(present, absent, late, total) {
                        $('#presentCount').text(present);
                        $('#absentCount').text(absent);
                        $('#lateCount').text(late);
                        $('#totalCount').text(total);
                    }
                    
                    // Function to recount all statuses
                    function recountAllStatuses() {
                        let presentCount = 0;
                        let absentCount = 0;
                        let lateCount = 0;
                        const totalCount = $('#studentsList tr').length;
                        
                        $('#studentsList tr').each(function() {
                            const status = $(this).find('input[type="radio"]:checked').val();
                            if (status === 'present') presentCount++;
                            else if (status === 'absent') absentCount++;
                            else if (status === 'late') lateCount++;
                        });
                        
                        updateCounters(presentCount, absentCount, lateCount, totalCount);
                    }

                    // Enable section dropdown when class is selected
                    // $('#class_id').change(function() {
                    //     const classId = $(this).val();
                    //     $('#section_id').empty().append('<option value="">Select Section</option>');
                        
                    //     if (classId) {
                    //         $('#section_id').prop('disabled', false);
                            
                    //         // Load sections for selected class
                    //         $.ajax({
                    //             url: '/attendance/get-sections',
                    //             type: 'GET',
                    //             data: { class_id: classId },
                    //             success: function(response) {
                    //                 if (response.sections.length > 0) {
                    //                     $.each(response.sections, function(index, section) {
                    //                         $('#section_id').append(`<option value="${section.id}">${section.name}</option>`);
                    //                     });
                    //                     // $('#loadStudentsBtn').prop('disabled', false);
                    //                 } else {
                    //                     $('#section_id').prop('disabled', true);
                    //                     $('#loadStudentsBtn').prop('disabled', true);
                    //                     showAlert('warning', 'No sections found for this class');
                    //                 }
                    //             }
                    //         });
                            
                    //     } else {
                    //         $('#section_id').prop('disabled', true);
                    //         $('#loadStudentsBtn').prop('disabled', true);
                    //     }
                    // });

                    $('#class_id').change(function() {
                        const classId = $(this).val();
                        const $sectionSelect = $('#section_id');
                        
                        // 1. Reset the section dropdown (works for both native and Select2)
                        $sectionSelect.val(null)             // Clear selected value
                                    .empty()               // Remove all options
                                    .append('<option value="">Select Section</option>')
                                    .prop('disabled', true) // Disable until sections load
                                    .trigger('change');    // Required for Select2 to update UI
                        
                        // 2. Reset dependent elements (if any)
                        $('#loadStudentsBtn').prop('disabled', true);
                        
                        // 3. If a class is selected, fetch its sections
                        if (classId) {
                            $('#attendanceSection').css('display', 'none');
                            // Show loading state
                            $sectionSelect.append('<option value="" disabled>Loading sections...</option>');
                            
                            // Load sections for selected class
                            $.ajax({
                                url: '/attendance/get-sections',
                                type: 'GET',
                                data: { class_id: classId },
                                success: function(response) {
                                    // Clear loading state
                                    $sectionSelect.empty().append('<option value="">Select Section</option>');
                                    
                                    // If sections exist, populate them
                                    if (response.sections?.length > 0) {
                                        $.each(response.sections, function(index, section) {
                                            $sectionSelect.append(`<option value="${section.id}">${section.name}</option>`);
                                        });
                                        $sectionSelect.prop('disabled', false)
                                                    .trigger('change'); // Update Select2 UI
                                    } else {
                                        showAlert('warning', 'No sections found for this class');
                                    }
                                },
                                error: function() {
                                    $sectionSelect.empty()
                                        .append('<option value="">Error loading sections</option>')
                                        .trigger('change');
                                    showAlert('error', 'Failed to load sections');
                                }
                            });
                        }
                    });
                    
                    // Load students when button is clicked
                    $('#loadStudentsBtn').click(function() {
                        const classId = $('#class_id').val();
                        const sectionId = $('#section_id').val();
                        const date = $('#attendance_date').val();
                        
                        if (!classId || !sectionId || !date) {
                            showAlert('danger', 'Please select class, section and date');
                            return;
                        }
                        
                        $(this).html('<i class="fa fa-spinner fa-spin"></i> Loading...').prop('disabled', true);
                        
                        $.ajax({
                            url: '/attendance/get-students',
                            type: 'GET',
                            data: { 
                                class_id: classId,
                                section_id: sectionId,
                                date: date
                            },
                            success: function(response) {
                                $('#loadStudentsBtn').html('<i class="fa fa-users"></i> Load Students').prop('disabled', true);
                                
                                if (response.students.length > 0) {
                                    $('#studentsList').empty();
                                    let presentCount = 0;
                                    let absentCount = 0;
                                    let lateCount = 0;
                                    
                                    $('#classSectionTitle').text(`${response.class.name} - ${response.section.name} (${date})`);
                                    
                                    $.each(response.students, function(index, student) {
                                        const existingAttendance = response.existingAttendance.find(a => a.user_id == student.student_id);
                                        const status = existingAttendance ? existingAttendance.status : '';
                                        const remarks = existingAttendance ? existingAttendance.remarks : '';
                                        
                                        if (status === 'present') presentCount++;
                                        else if (status === 'absent') absentCount++;
                                        else if (status === 'late') lateCount++;
                                        
                                        $('#studentsList').append(`
                                            <tr class="status-${status || 'undefined'}" data-student-id="${student.student_id}">
                                                <td>${index + 1}</td>
                                                <td>
                                                    <img src="${student.student_photo || '/backend/img/student-default.png'}" 
                                                        alt="${student.student.name}" class="student-photo">
                                                </td>
                                                <td>${student.student.name}</td>
                                                <td>${student.admission_no}</td>
                                                <td>
                                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                                        <label class="btn btn-sm btn-outline-success attendance-status-btn ${status === 'present' ? 'active' : ''}">
                                                            <input type="radio" name="attendance_${student.student_id}" 
                                                                value="present" ${status === 'present' ? 'checked' : ''}> Present
                                                        </label>
                                                        <label class="btn btn-sm btn-outline-danger attendance-status-btn ${status === 'absent' ? 'active' : ''}">
                                                            <input type="radio" name="attendance_${student.student_id}" 
                                                                value="absent" ${status === 'absent' ? 'checked' : ''}> Absent
                                                        </label>
                                                        <label class="btn btn-sm btn-outline-warning attendance-status-btn ${status === 'late' ? 'active' : ''}">
                                                            <input type="radio" name="attendance_${student.student_id}" 
                                                                value="late" ${status === 'late' ? 'checked' : ''}> Late
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="remarks-text">${remarks || ''}</span>
                                                    <button class="btn btn-sm btn-outline-primary add-remarks-btn float-right" 
                                                            data-student-id="${student.student_id}">
                                                        <i class="fa fa-comment"></i>
                                                    </button>
                                                </td>
                                                <td>
                                                    <button class="btn btn-sm btn-info view-history-btn" 
                                                            data-student-id="${student.student_id}"
                                                            title="View Attendance History">
                                                        <i class="fa fa-history"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        `);
                                    });
                                    
                                    updateCounters(presentCount, absentCount, lateCount, response.students.length);
                                    $('#attendanceSection').show();
                                } else {
                                    showAlert('warning', 'No students found in this class/section');
                                    $('#attendanceSection').hide();
                                }
                            },
                            error: function() {
                                $('#loadStudentsBtn').html('<i class="fa fa-users"></i> Load Students').prop('disabled', false);
                                showAlert('danger', 'Failed to load students');
                            }
                        });
                    });
                    
                    // Bulk action buttons
                    $('body').on('click', '.bulk-action-btn', function() {
                        const status = $(this).data('status');
                        
                        $(`input[type="radio"][value="${status}"]`).prop('checked', true).trigger('change');
                        $(`.attendance-status-btn`).removeClass('active');
                        $(`.attendance-status-btn input[value="${status}"]`).parent().addClass('active');
                        
                        $('#studentsList tr').removeClass('status-present status-absent status-late status-undefined')
                                            .addClass(`status-${status}`);
                        
                        recountAllStatuses();
                    });
                    
                    // Handle attendance status change
                    $('body').on('change', 'input[type="radio"][name^="attendance_"]', function() {
                        const status = $(this).val();
                        $(this).closest('tr').removeClass('status-present status-absent status-late status-undefined')
                                        .addClass(`status-${status}`);
                        
                        recountAllStatuses();
                    });
                    
                    // Add remarks button click
                    $('body').on('click', '.add-remarks-btn', function() {
                        const studentId = $(this).data('student-id');
                        const remarks = $(this).siblings('.remarks-text').text();
                        
                        $('#remarksStudentId').val(studentId);
                        $('#remarksText').val(remarks);
                        $('#remarksModal').modal('show');
                    });
                    
                    // Save remarks
                    $('#saveRemarksBtn').click(function() {
                        const studentId = $('#remarksStudentId').val();
                        const remarks = $('#remarksText').val();
                        const leaveType = $('#leaveType').val();
                        
                        $(`tr[data-student-id="${studentId}"] .remarks-text`).text(remarks);
                        
                        if ($(`tr[data-student-id="${studentId}"] input[value="absent"]:checked`).length > 0 && leaveType) {
                            const currentRemarks = $(`tr[data-student-id="${studentId}"] .remarks-text`).text();
                            const leaveTypeText = `[Leave Type: ${$('#leaveType option:selected').text()}]`;
                            
                            if (currentRemarks) {
                                $(`tr[data-student-id="${studentId}"] .remarks-text`).text(`${currentRemarks} ${leaveTypeText}`);
                            } else {
                                $(`tr[data-student-id="${studentId}"] .remarks-text`).text(leaveTypeText);
                            }
                        }
                        
                        $('#remarksModal').modal('hide');
                    });
                    
                    // View history button click
                    $('body').on('click', '.view-history-btn', function() {
                        const studentId = $(this).data('student-id');
                        showAlert('info', `Would show attendance history for student ID: ${studentId}`);
                    });
                    
                    // Save as draft
                    $('#saveAsDraftBtn').click(function() {
                        saveAttendance('draft');
                    });
                    
                    // Submit attendance
                    $('#submitAttendanceBtn').click(function() {
                        saveAttendance('submitted');
                    });
                    
                    // Function to save attendance
                    function saveAttendance(status) {
                        const classId = $('#class_id').val();
                        const sectionId = $('#section_id').val();
                        const date = $('#attendance_date').val();
                        const subjectId = $('#subject_id').val();
                        // const sessionType = $('#session_type').val();
                        
                        if (!classId || !sectionId || !date) {
                            showAlert('danger', 'Please select class, section and date');
                            return;
                        }
                        
                        const attendanceData = [];
                        $('#studentsList tr').each(function() {
                            const studentId = $(this).data('student-id');
                            const status = $(this).find('input[type="radio"]:checked').val() || '';
                            const remarks = $(this).find('.remarks-text').text();
                            
                            attendanceData.push({
                                student_id: studentId,
                                status: status,
                                remarks: remarks
                            });
                        });
                        
                        const btn = status === 'draft' ? $('#saveAsDraftBtn') : $('#submitAttendanceBtn');
                        const originalText = btn.html();
                        btn.html('<i class="fa fa-spinner fa-spin"></i> Saving...').prop('disabled', true);
                        
                        $.ajax({
                            url: '/attendance/save',
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                class_id: classId,
                                section_id: sectionId,
                                date: date,
                                subject_id: subjectId,
                                // session_type: sessionType,
                                status: status,
                                attendance: attendanceData
                            },
                            success: function(response) {
                                btn.html(originalText).prop('disabled', false);
                                showAlert('success', response.message);
                                
                                if (status === 'submitted') {
                                    window.location.href = '/attendance';
                                }
                            },
                            error: function(xhr) {
                                btn.html(originalText).prop('disabled', false);
                                showAlert('danger', xhr.responseJSON.message || 'Failed to save attendance');
                            }
                        });
                    }
                });
                // check is there any class on this day
                $(document).ready(function() {
                    $('#attendance_date').change(function() {

                        var classId = $('#class_id').val();
                        var sectionId = $('#section_id').val();
                        var selectedDate = $(this).val();
                        
                        // Clear previous result
                        $('#class_check_result').html('');
                        $('#loadStudentsBtn').prop('disabled', true);

                        
                        // Make Ajax request
                        $.ajax({
                            url: '/check-classes', // Replace with your actual endpoint
                            type: 'GET',
                            data: {
                                class_id     : classId,
                                section_id   : sectionId,
                                date        : selectedDate
                            },
                            dataType: 'json',
                            success: function(response) {
                                if(response.has_classes) {
                                    $('#loadStudentsBtn').prop('disabled', false);

                                    $('#class_check_result').html('<div class="alert alert-success">Classes are scheduled for this date.</div>');
                                } else {
                                    $('#loadStudentsBtn').prop('disabled', true);

                                    $('#class_check_result').html('<div class="alert alert-warning">No classes found for this date or class.</div>');
                                }
                            },
                            error: function(xhr) {
                                $('#loadStudentsBtn').prop('disabled', true);

                                $('#class_check_result').html('<div class="alert alert-danger">Error checking classes.</div>');
                            }
                        });
                    });
                });
            </script>
        @endpush

   </x-tenant-app-layout>
