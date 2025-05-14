<x-tenant-app-layout>
    @push('css')
    <!-- favicon
    ============================================ -->
    <link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico">
    <!-- Google Fonts
        ============================================ -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,700,900" rel="stylesheet">
    <!-- Bootstrap CSS
        ============================================ -->
    <link rel="stylesheet" href="{{ asset('backend/css/bootstrap.min.css') }}">
    <!-- Bootstrap CSS
        ============================================ -->
    <link rel="stylesheet" href="{{ asset('backend/css/font-awesome.min.css') }}">
    <!-- owl.carousel CSS
        ============================================ -->
    <link rel="stylesheet" href="{{ asset('backend/css/owl.carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/css/owl.theme.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/css/owl.transitions.css') }}">
    <!-- animate CSS
        ============================================ -->
    <link rel="stylesheet" href="{{ asset('backend/css/animate.css') }}">
    <!-- normalize CSS
        ============================================ -->
    <link rel="stylesheet" href="{{ asset('backend/css/normalize.css') }}">
    <!-- meanmenu icon CSS
        ============================================ -->
    <link rel="stylesheet" href="{{ asset('backend/css/meanmenu.min.css') }}">
    <!-- main CSS
        ============================================ -->
    <link rel="stylesheet" href="{{ asset('backend/css/main.css') }}">
    <!-- educate icon CSS
        ============================================ -->
    <link rel="stylesheet" href="{{ asset('backend/css/educate-custon-icon.css') }}">
    <!-- morrisjs CSS
        ============================================ -->
    <link rel="stylesheet" href="{{ asset('backend/css/morrisjs/morris.css') }}">
    <!-- mCustomScrollbar CSS
        ============================================ -->
    <link rel="stylesheet" href="{{ asset('backend/css/scrollbar/jquery.mCustomScrollbar.min.css') }}">
    <!-- metisMenu CSS
        ============================================ -->
    <link rel="stylesheet" href="{{ asset('backend/css/metisMenu/metisMenu.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/css/metisMenu/metisMenu-vertical.css') }}">
    <!-- calendar CSS
        ============================================ -->
    <link rel="stylesheet" href="{{ asset('backend/css/calendar/fullcalendar.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/css/calendar/fullcalendar.print.min.css') }}">
    <!-- x-editor CSS
        ============================================ -->
    <link rel="stylesheet" href="{{ asset('backend/css/editor/select2.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/css/editor/datetimepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/css/editor/bootstrap-editable.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/css/editor/x-editor-style.css') }}">
    <!-- normalize CSS
        ============================================ -->
    <link rel="stylesheet" href="{{ asset('backend/css/data-table/bootstrap-table.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/css/data-table/bootstrap-editable.css') }}">
    <!-- style CSS
        ============================================ -->
    <link rel="stylesheet" href="{{ asset('backend/style.css') }}">
    <!-- responsive CSS
        ============================================ -->
    <link rel="stylesheet" href="{{ asset('backend/css/responsive.css') }}">
    <!-- modernizr JS
        ============================================ -->
    <script src="{{ asset('backend/js/vendor/modernizr-2.8.3.min.js') }}"></script>
    <style>
        .hover-table tbody tr:hover td {
            background-color: #f5f5f5;
        }
        .hover-table td {
            vertical-align: top;
        }
        .hover-table td li {
            list-style-type: none;
            padding: 2px 0;
        }
        .btn-sm {
            padding: 3px 8px;
            font-size: 12px;
            margin: 2px;
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
                                <h3>Create Timetable</h3>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <ul class="breadcome-menu">
                                <li>
                                    <a href="{{ route('admin.timetable.index') }}" class="btn btn-primary btn-sm" style="color: white">
                                        <i class="fa fa-arrow-left"></i> Back
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
                            <div class="row">
                                <form id="timetableForm" method="POST" action="{{ route('admin.timetable.store') }}">
                                    @csrf
                                    
                                    <!-- Class and Section Selection -->
                                    <div class="col-lg-12">
                                        <div class="all-form-element-inner">
                                            <div class="section-headline">
                                                <h3>Basic Information</h3>
                                            </div>
                                            
                                            <!-- Class -->
                                            <div class="form-group-inner">
                                                <div class="row">
                                                    <div class="col-lg-4"><label class="login2">Class*</label></div>
                                                    <div class="col-lg-8">
                                                        <select name="class_id" id="class_id" class="form-control @error('class_id') is-invalid @enderror" required>
                                                            <option value="">Select Class</option>
                                                            @foreach($classes as $class)
                                                                <option value="{{ $class->id }}">{{ $class->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('class_id') <small class="text-danger">{{ $message }}</small> @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- Section -->
                                            <div class="form-group-inner">
                                                <div class="row">
                                                    <div class="col-lg-4"><label class="login2">Section*</label></div>
                                                    <div class="col-lg-8">
                                                        <select name="section_id" id="section_id" class="form-control @error('section_id') is-invalid @enderror" required disabled>
                                                            <option value="">Select Class First</option>
                                                        </select>
                                                        @error('section_id') <small class="text-danger">{{ $message }}</small> @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Timetable Periods -->
                                    <div class="col-lg-12">
                                        <div class="all-form-element-inner">
                                            <div class="section-headline">
                                                <h3>Timetable Periods</h3>
                                                <button type="button" id="addPeriod" class="btn btn-success btn-sm">Add Period</button>
                                            </div>
                                            
                                            <div id="periodsContainer">
                                                <!-- Periods will be added here dynamically -->
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Submit Button -->
                                    <div class="col-lg-12">
                                        <div class="form-group-inner">
                                            <div class="login-btn-inner">
                                                <div class="row">
                                                    <div class="col-lg-4"></div>
                                                    <div class="col-lg-8">
                                                        <div class="login-horizental">
                                                            <button type="submit" class="btn btn-sm btn-primary login-submit-cs">Save Timetable</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
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
        <script>
            $(document).ready(function() {
                let periodCount = 0;
                
                // Add new period
                $('#addPeriod').click(function() {
                    const periodId = `period_${periodCount++}`;
                    const periodHtml = `
                    <div class="period-group" id="${periodId}">
                        <div class="form-group-inner">
                            <div class="row">
                                <div class="col-lg-12">
                                    <h4>Period ${periodCount}</h4>
                                    <button type="button" class="btn btn-danger btn-xs remove-period" data-period="${periodId}">
                                        <i class="fa fa-trash"></i> Remove
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group-inner">
                            <div class="row">
                                <div class="col-lg-4"><label class="login2">Day*</label></div>
                                <div class="col-lg-8">
                                    <select name="periods[${periodCount}][day]" class="form-control" required>
                                        <option value="Monday">Monday</option>
                                        <option value="Tuesday">Tuesday</option>
                                        <option value="Wednesday">Wednesday</option>
                                        <option value="Thursday">Thursday</option>
                                        <option value="Friday">Friday</option>
                                        <option value="Saturday">Saturday</option>
                                        <option value="Sunday">Sunday</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group-inner">
                            <div class="row">
                                <div class="col-lg-4"><label class="login2">Period Name*</label></div>
                                <div class="col-lg-8">
                                    <input type="text" name="periods[${periodCount}][period_name]" 
                                        class="form-control period-name-input" 
                                        placeholder="e.g. First Period"
                                        required>
                                </div>
                            </div>
                        </div>

                        
                        
                        <div class="form-group-inner">
                            <div class="row">
                                <div class="col-lg-4"><label class="login2">Start Time*</label></div>
                                <div class="col-lg-8">
                                    <input type="time" name="periods[${periodCount}][start_time]" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group-inner">
                            <div class="row">
                                <div class="col-lg-4"><label class="login2">End Time*</label></div>
                                <div class="col-lg-8">
                                    <input type="time" name="periods[${periodCount}][end_time]" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group-inner">
                            <div class="row">
                                <div class="col-lg-4"><label class="login2">Is Break?</label></div>
                                <div class="col-lg-8">
                                    <input type="checkbox" name="periods[${periodCount}][is_break]" class="is-break-checkbox">
                                </div>
                            </div>
                        </div>
                        
                        <div class="break-fields" style="display: none;">
                            <div class="form-group-inner">
                                <div class="row">
                                    <div class="col-lg-4"><label class="login2">Break Name</label></div>
                                    <div class="col-lg-8">
                                        <input type="text" name="periods[${periodCount}][break_name]" class="form-control" placeholder="e.g. Lunch Break">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="subject-fields mb-2">
                            <div class="form-group-inner">
                                <div class="row">
                                    <div class="col-lg-4"><label class="login2">Subject</label></div>
                                    <div class="col-lg-8">
                                        <select name="periods[${periodCount}][subject_id]" class="form-control subject-select" onchange="fetchTeachers(this, ${periodCount})">
                                            <option value="">Select Subject</option>
                                            @foreach($subjects as $subject)
                                                <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group-inner">
                                <div class="row">
                                    <div class="col-lg-4"><label class="login2">Teacher</label></div>
                                    <div class="col-lg-8">
                                        <select name="periods[${periodCount}][teacher_id]" class="form-control teacher-select" id="teacher-select-${periodCount}">
                                            <option value="">Select Teacher</option>
                                            @foreach($teachers as $teacher)
                                                <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group-inner">
                            <div class="row">
                                <div class="col-lg-4"><label class="login2">Room Number</label></div>
                                <div class="col-lg-8">
                                    <input type="text" name="periods[${periodCount}][room_number]" class="form-control" placeholder="e.g. Room 101">
                                </div>
                            </div>
                        </div>
                        
                        <hr>
                    </div>`;
                    
                    $('#periodsContainer').append(periodHtml);
                });
                
                // Remove period
                $(document).on('click', '.remove-period', function() {
                    const periodId = $(this).data('period');
                    $(`#${periodId}`).remove();
                });
                
                // Toggle break/subject fields
                $(document).on('change', '.is-break-checkbox', function() {
                    const container = $(this).closest('.period-group');
                    if ($(this).is(':checked')) {
                        container.find('.break-fields').show();
                        container.find('.subject-fields').hide();
                    } else {
                        container.find('.break-fields').hide();
                        container.find('.subject-fields').show();
                    }
                });
            });
        </script>
        
        <script>
            // Validate before form submission
            $('#timetableForm').on('submit', function(e) {
                timeSlots = {};
                let hasError = false;

                $('.period-group').each(function(index) {
                    const day = $(this).find('[name*="[day]"]').val();
                    const startTime = $(this).find('[name*="[start_time]"]').val();
                    const classId = $('#class_id').val();
                    const sectionId = $('#section_id').val();
                    
                    const timeSlotKey = `${classId}-${sectionId}-${day}-${startTime}`;
                    
                    if (timeSlots[timeSlotKey]) {
                        alert(`Error: Duplicate time slot detected for ${day} at ${startTime}`);
                        hasError = true;
                        return false; // break out of loop
                    }
                    
                    timeSlots[timeSlotKey] = true;
                });

                if (hasError) {
                    e.preventDefault();
                    return false;
                }
                
                return true;
            });
        </script>

        <script>
            $(document).ready(function() {
                $('#class_id').change(function() {
                    var classId = $(this).val();
                    var sectionSelect = $('#section_id');
                    
                    if (classId) {
                        // Disable section dropdown while loading
                        sectionSelect.prop('disabled', true);
                        sectionSelect.html('<option value="">Loading sections...</option>');
                        
                        // Fetch sections for selected class
                        $.ajax({
                            url: '/get-sections/' + classId, // Update this route to match your backend
                            method: 'GET',
                            success: function(response) {
                                console.log(response);
                                if (response && Object.keys(response).length > 0) {
                                    var options = '<option value="">Select Section</option>';
                                    // Handle object response format {id: name}
                                    $.each(response, function(id, name) {
                                        options += '<option value="' + id + '">' + name + '</option>';
                                    });
                                    sectionSelect.html(options);
                                } else {
                                    sectionSelect.html('<option value="">No sections available</option>');
                                }
                                sectionSelect.prop('disabled', false);
                            },
                            error: function() {
                                sectionSelect.html('<option value="">Error loading sections</option>');
                                sectionSelect.prop('disabled', false);
                            }
                        });
                    } else {
                        sectionSelect.html('<option value="">Select Class First</option>');
                        sectionSelect.prop('disabled', true);
                    }
                });
            });
        </script>
        <script>
            function fetchTeachers(selectElement, periodCount) {
                const subjectId = selectElement.value;
                const classId = $('#class_id').val();
                const teacherSelect = $(`#teacher-select-${periodCount}`);
                
                if (!subjectId || !classId) {
                    teacherSelect.html('<option value="">Select Class and SubjectFirst</option>');
                    return;
                }
                
                $.ajax({
                    url: '{{ route("admin.getTeachersBySubject") }}',
                    type: 'GET',
                    data: {
                        subject_id: subjectId,
                        class_id: classId
                    },
                    success: function(response) {
                        let options = '<option value="">Select Teacher</option>';
                        
                        if (response.teachers && response.teachers.length > 0) {
                            response.teachers.forEach(function(teacher) {
                                // Mark the assigned teacher as selected if available
                                const selected = (response.assigned_teacher_id && teacher.id == response.assigned_teacher_id) ? 'selected' : '';
                                options += `<option value="${teacher.id}" ${selected}>${teacher.name}</option>`;
                            });
                        }
                        
                        // Also include all teachers as options
                        @foreach($teachers as $teacher)
                            if (!options.includes(`value="{{ $teacher->id }}"`)) {
                                options += `<option value="{{ $teacher->id }}">{{ $teacher->name }}</option>`;
                            }
                        @endforeach
                        
                        teacherSelect.html(options);
                    },
                    error: function(xhr) {
                        console.error(xhr);
                        teacherSelect.html('<option value="">Error loading teachers</option>');
                    }
                });
            }

            // Add this to your document.ready function
            $('#class_id').change(function() {
                $('.subject-select').each(function() {
                    const periodCount = $(this).closest('.period-group').index() + 1;
                    if ($(this).val()) {
                        fetchTeachers(this, periodCount);
                    }
                });
            });
        </script>
    @endpush
</x-tenant-app-layout>