<x-tenant-app-layout>
    @push('css')
        <link rel="stylesheet" href="{{ asset('backend/css/editor/select2.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/editor/datetimepicker.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/editor/bootstrap-editable.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/editor/x-editor-style.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/data-table/bootstrap-table.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/data-table/bootstrap-editable.css') }}">
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
    
    <div class="data-table-area mg-b-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="breadcome-list">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="breadcome-heading" style="margin-top: 10px">
                                    <h3>All Classes Timetable</h3>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <ul class="breadcome-menu">
                                    <li>
                                        <a href="{{ route('admin.timetable.create') }}" class="btn btn-primary btn-sm" style="color: white">
                                            <i class="fa fa-plus"></i> Add Timetable
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>


                @foreach($timetables as $timetable)
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="sparkline13-list">
                            <div class="sparkline13-hd">
                                <div class="main-sparkline13-hd">
                                    <h1>{{ $timetable['class_name'] }}</h1>
                                </div>
                            </div>
                            <div class="sparkline13-graph">
                                <div class="datatable-dashv1-list custom-datatable-overright">
                                    <div id="toolbar-{{ $loop->index }}">
                                        <select class="form-control dt-tb">
                                            <option value="">Excel</option>
                                            <option value="">PDF</option>
                                            <option value="">CSV</option>
                                        </select>
                                    </div>
                                    <table id="timetable-table-{{ $loop->index }}" 
                                        class="table hover-table timetable-datatable"
                                        data-toggle="table" 
                                        data-pagination="true" 
                                        data-search="true"
                                        {{-- data-show-columns="true"  --}}
                                        {{-- data-show-pagination-switch="true"  --}}
                                        {{-- data-show-refresh="true" --}}
                                        {{-- data-key-events="true"  --}}
                                        {{-- data-show-toggle="true"  --}}
                                        data-resizable="true"
                                        {{-- data-cookie="true" --}}
                                        data-cookie-id-table="timetable-{{ $loop->index }}"
                                        {{-- data-show-export="true"  --}}
                                        {{-- data-click-to-select="true" --}}
                                         {{-- data-export-types="['csv', 'txt', 'excel']" --}}
                                        data-toolbar="#toolbar-{{ $loop->index }}">
                                        <thead>
                                            <tr>
                                                {{-- <th data-field="state" data-checkbox="true"></th> --}}
                                                <th data-field="period" data-sortable="true">Periods</th>
                                                <th data-field="monday" data-sortable="false">Monday</th>
                                                <th data-field="tuesday" data-sortable="false">Tuesday</th>
                                                <th data-field="wednesday" data-sortable="false">Wednesday</th>
                                                <th data-field="thursday" data-sortable="false">Thursday</th>
                                                <th data-field="friday" data-sortable="false">Friday</th>
                                                <th data-field="saturday" data-sortable="false">Saturday</th>
                                                <th data-field="sunday" data-sortable="false">Sunday</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($timetable['periods'] as $periodName => $days)
                                            <tr>
                                                {{-- <td></td> --}}
                                                <td style="font-style: italic">{{ $periodName }}</td>
                                                @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                                                <td>
                                                    @if(isset($days[$day]))
                                                        @if(isset($days[$day]['event']))
                                                            <div class="timetable-event">
                                                                <div><strong>Event:</strong> {{ $days[$day]['event'] }}</div>
                                                                <div><strong>Time:</strong> {{ $days[$day]['start'] }} - {{ $days[$day]['end'] }}</div>
                                                                <div><strong>Room:</strong> {{ $days[$day]['room'] }}</div>
                                                            </div>
                                                        @else
                                                            <div class="timetable-class">
                                                                <div><strong>Teacher:</strong> {{ $days[$day]['teacher'] }}</div>
                                                                <div><strong>Subject:</strong> {{ $days[$day]['subject'] }}</div>
                                                                <div><strong>Time:</strong> {{ $days[$day]['start'] }} - {{ $days[$day]['end'] }}</div>
                                                                <div><strong>Room:</strong> {{ $days[$day]['room'] }}</div>
                                                            </div>
                                                        @endif
                                                        <div class="timetable-actions">
                                                            {{-- <button class="btn btn-primary btn-sm update-btn" 
                                                                    data-class="{{ $timetable['class_name'] }}"
                                                                    data-period="{{ $periodName }}"
                                                                    data-day="{{ $day }}"
                                                                    data-teacher="{{ $days[$day]['teacher'] ?? '' }}"
                                                                    data-subject="{{ $days[$day]['subject'] ?? '' }}"
                                                                    data-start="{{ $days[$day]['start'] ?? '' }}"
                                                                    data-end="{{ $days[$day]['end'] ?? '' }}"
                                                                    data-room="{{ $days[$day]['room'] ?? '' }}"
                                                                    data-event="{{ $days[$day]['event'] ?? '' }}">
                                                                <i class="fa fa-pencil"></i> Update
                                                            </button> --}}

                                                            <button class="btn btn-primary btn-sm update-btn" 
                                                                data-entry-id="{{ $days[$day]['id'] }}"
                                                                data-class="{{ $timetable['class_name'] }}"
                                                                data-class_id="{{ $timetable['class_id'] }}"
                                                                data-period="{{ $periodName }}"
                                                                data-day="{{ $day }}"
                                                                data-section_id="{{ $timetable['section_id'] }}"
                                                                data-teacher="{{ $days[$day]['teacher'] ?? '' }}"
                                                                data-teacher_id="{{ $days[$day]['teacher_id'] ?? '' }}"
                                                                data-subject="{{ $days[$day]['subject'] ?? '' }}"
                                                                data-subject_id="{{ $days[$day]['subject_id'] ?? '' }}"
                                                                data-start="{{ $days[$day]['start_raw'] ?? '' }}"
                                                                data-end="{{ $days[$day]['end_raw'] ?? '' }}"
                                                                data-room="{{ $days[$day]['room'] ?? '' }}"
                                                                data-event="{{ $days[$day]['event'] ?? '' }}">
                                                            <i class="fa fa-pencil"></i> Update
                                                        </button>
                                                            <button class="btn btn-info btn-sm view-btn"
                                                                    data-class="{{ $timetable['class_name'] }}"
                                                                    data-period="{{ $periodName }}"
                                                                    data-day="{{ $day }}"
                                                                    data-teacher="{{ $days[$day]['teacher'] ?? '' }}"
                                                                    data-subject="{{ $days[$day]['subject'] ?? '' }}"
                                                                    data-start="{{ $days[$day]['start'] ?? '' }}"
                                                                    data-end="{{ $days[$day]['end'] ?? '' }}"
                                                                    data-room="{{ $days[$day]['room'] ?? '' }}"
                                                                    data-event="{{ $days[$day]['event'] ?? '' }}">
                                                                <i class="fa fa-eye"></i> View
                                                            </button>
                                                        </div>
                                                    @else
                                                        <div class="timetable-empty">
                                                            <div><strong>Teacher:</strong> --</div>
                                                            <div><strong>Subject:</strong> --</div>
                                                            <div><strong>Time:</strong> --</div>
                                                            <div><strong>Room:</strong> --</div>
                                                        </div>
                                                        <div class="timetable-actions">
                                                            <button class="btn btn-success btn-sm add-btn"
                                                                    data-class_id="{{ $timetable['class_id'] }}"
                                                                    data-class="{{ $timetable['class_name'] }}"
                                                                    data-period="{{ $periodName }}"
                                                                    data-section_id="{{ $timetable['section_id'] }}"
                                                                    data-day="{{ $day }}">
                                                                <i class="fa fa-plus"></i> Add
                                                            </button>
                                                        </div>
                                                    @endif
                                                </td>
                                                @endforeach
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>





<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="addModalLabel">Add Schedule</h4>
            </div>
            <div class="modal-body">
                <form id="addForm" method="post">
                    @csrf
                    <input type="hidden" name="class" id="addClass">
                    <input type="hidden" name="class_id" id="addClassId">
                    <input type="hidden" name="period" id="addPeriod">
                    <input type="hidden" name="section_id" id="addPeriodId">
                    <input type="hidden" name="day" id="addDay">
                    
                    
                    <div class="form-group">
                        <label>Type</label>
                        <select class="form-control" name="type" id="addType">
                            <option value="class">Class</option>
                            <option value="event">Event/Break Time</option>
                        </select>
                    </div>
                    
                    <div class="form-group class-fields">
                        <label>Subject</label>
                        <select class="form-control" name="subject" id="addSubject" onchange="fetchModalTeachers(this)">
                            <option value="">Select Subject</option>
                            <!-- Subjects will be loaded via AJAX -->
                        </select>
                    </div>
                    
                    <div class="form-group class-fields">
                        <label>Teacher</label>
                        <select class="form-control" name="teacher" id="addTeacher">
                            <option value="">Select Teacher</option>
                            <!-- Teachers will be loaded via AJAX -->
                        </select>
                    </div>
                    
                    <div class="form-group event-fields" style="display: none;">
                        <label>Event Label</label>
                        <input type="text" class="form-control" name="event" id="addEvent">
                    </div>
                    
                    <div class="form-group">
                        <label>Start Time</label>
                        <input type="time" class="form-control schedule-start" name="start" id="addStart" required>
                    </div>
                    
                    <div class="form-group">
                        <label>End Time</label>
                        <input type="time" class="form-control schedule-end" name="end" id="addEnd" required>
                        <small class="text-muted schedule-time-hint">End time must be at least 1 minute after start time.</small>
                    </div>
                    
                    <div class="form-group class-fields">
                        <label>Room</label>
                        <input type="text" class="form-control" name="room" id="addRoom">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveAdd">Save</button>
            </div>
        </div>
    </div>
</div>

<!-- Update Modal -->
<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="updateModalLabel">Update Schedule</h4>
            </div>
            <div class="modal-body">
                <form id="updateForm">
                    @csrf
                    <input type="hidden" name="entry_id" id="updateEntryId">
                    <input type="hidden" name="class" id="updateClass">
                    <input type="hidden" name="period" id="updatePeriod">
                    <input type="hidden" name="day" id="updateDay">
                    <input type="hidden" name="class_id" id="updateClassId">
                    <input type="hidden" name="section_id" id="updateSectionId">
                    
                    <div class="form-group">
                        <label>Type</label>
                        <select class="form-control" name="type" id="updateType">
                            <option value="class">Class</option>
                            <option value="event">Event/Break Time</option>
                        </select>
                    </div>
                    
                    <div class="form-group class-fields">
                        <label>Subject</label>
                        <select class="form-control" name="subject" id="updateSubject" onchange="fetchUpdateTeachers(this)">
                            <option value="">Select Subject</option>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}">{{ $subject->name }} ({{ $subject->code }})</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-group class-fields">
                        <label>Teacher</label>
                        <select class="form-control" name="teacher" id="updateTeacher">
                            <option value="">Select Teacher</option>
                            @foreach($teachers as $teacher)
                                @php
                                    $employeeId = $teacher->teacherProfile && $teacher->teacherProfile->employee_id 
                                        ? $teacher->teacherProfile->employee_id 
                                        : 'N/A';
                                @endphp
                                <option value="{{ $teacher->id }}">{{ $teacher->name }} ({{ $employeeId }})</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-group event-fields" style="display: none;">
                        <label>Event Label</label>
                        <input type="text" class="form-control" name="event" id="updateEvent">
                    </div>
                    
                    <div class="form-group">
                        <label>Start Time</label>
                        <input type="time" class="form-control schedule-start" name="start" id="updateStart" required>
                    </div>
                    
                    <div class="form-group">
                        <label>End Time</label>
                        <input type="time" class="form-control schedule-end" name="end" id="updateEnd" required>
                        <small class="text-muted schedule-time-hint">End time must be at least 1 minute after start time.</small>
                    </div>
                    
                    <div class="form-group">
                        <label>Room</label>
                        <input type="text" class="form-control" name="room" id="updateRoom">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveUpdate">Save Changes</button>
            </div>
        </div>
    </div>
</div>

<!-- View Modal -->
<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="viewModalLabel">Schedule Details</h4>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th width="30%">Class</th>
                                <td id="viewClass"></td>
                            </tr>
                            <tr>
                                <th>Period</th>
                                <td id="viewPeriod"></td>
                            </tr>
                            <tr>
                                <th>Day</th>
                                <td id="viewDay"></td>
                            </tr>
                            <tr class="dynamic-display class-fields">
                                <th>Teacher</th>
                                <td id="viewTeacher"></td>
                            </tr>
                            <tr class="dynamic-display class-fields">
                                <th>Subject</th>
                                <td id="viewSubject"></td>
                            </tr>
                            <tr class="dynamic-display event-fields">
                                <th>Event</th>
                                <td id="viewEvent"></td>
                            </tr>
                            <tr>
                                <th>Start Time</th>
                                <td id="viewStart"></td>
                            </tr>
                            <tr>
                                <th>End Time</th>
                                <td id="viewEnd"></td>
                            </tr>
                            <tr>
                                <th>Room</th>
                                <td id="viewRoom"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

    @push('js')
        <script src="{{ asset('backend/js/data-table/bootstrap-table.js') }}"></script>
        <script src="{{ asset('backend/js/data-table/tableExport.js') }}"></script>
        <script src="{{ asset('backend/js/data-table/data-table-active.js') }}"></script>
        <script src="{{ asset('backend/js/data-table/bootstrap-table-editable.js') }}"></script>
        <script src="{{ asset('backend/js/data-table/bootstrap-editable.js') }}"></script>
        <script src="{{ asset('backend/js/data-table/bootstrap-table-resizable.js') }}"></script>
        <script src="{{ asset('backend/js/data-table/colResizable-1.5.source.js') }}"></script>
        <script src="{{ asset('backend/js/data-table/bootstrap-table-export.js') }}"></script>
        <script src="{{ asset('backend/js/editable/jquery.mockjax.js') }}"></script>
        <script src="{{ asset('backend/js/editable/mock-active.js') }}"></script>
        <script src="{{ asset('backend/js/editable/select2.js') }}"></script>
        <script src="{{ asset('backend/js/editable/moment.min.js') }}"></script>
        <script src="{{ asset('backend/js/editable/bootstrap-datetimepicker.js') }}"></script>
        <script src="{{ asset('backend/js/editable/bootstrap-editable.js') }}"></script>
        <script src="{{ asset('backend/js/editable/xediable-active.js') }}"></script>
        <script src="{{ asset('backend/js/chart/jquery.peity.min.js') }}"></script>
        <script src="{{ asset('backend/js/peity/peity-active.js') }}"></script>
        <script src="{{ asset('backend/js/tab.js') }}"></script>
        
        <script>
            function addMinutesToTime(timeValue, minutesToAdd) {
                if (!timeValue) {
                    return '';
                }

                var parts = timeValue.split(':');
                var totalMinutes = (parseInt(parts[0], 10) * 60) + parseInt(parts[1], 10) + minutesToAdd;
                var hours = Math.floor(totalMinutes / 60) % 24;
                var minutes = totalMinutes % 60;

                return String(hours).padStart(2, '0') + ':' + String(minutes).padStart(2, '0');
            }

            function validateScheduleTimes(form) {
                var start = form.find('.schedule-start').val();
                var end = form.find('.schedule-end').val();

                if (!start || !end) {
                    alert('Please enter both start and end time.');
                    return false;
                }

                var startParts = start.split(':');
                var endParts = end.split(':');
                var startMinutes = (parseInt(startParts[0], 10) * 60) + parseInt(startParts[1], 10);
                var endMinutes = (parseInt(endParts[0], 10) * 60) + parseInt(endParts[1], 10);

                if (endMinutes <= startMinutes) {
                    alert('End time must be at least 1 minute after start time.');
                    form.find('.schedule-end').focus();
                    return false;
                }

                return true;
            }

            function bindScheduleTimeValidation(formSelector) {
                var form = $(formSelector);

                form.on('change', '.schedule-start', function() {
                    var start = $(this).val();
                    var endField = form.find('.schedule-end');

                    if (!start) {
                        return;
                    }

                    var minimumEnd = addMinutesToTime(start, 1);
                    endField.attr('min', minimumEnd);

                    if (endField.val() && endField.val() <= start) {
                        endField.val(minimumEnd);
                    }
                });
            }

            function showScheduleError(xhr) {
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    var messages = Object.values(xhr.responseJSON.errors).flat();
                    alert(messages.join('\n'));
                    return;
                }

                alert('Error saving schedule. Please try again.');
            }

            $(document).ready(function() {
                bindScheduleTimeValidation('#addForm');
                bindScheduleTimeValidation('#updateForm');

                // Handle type change in add and update forms
                $('select[name="type"]').change(function() {
                    if ($(this).val() === 'event') {
                        $(this).closest('.modal-content').find('.event-fields').show();
                        $(this).closest('.modal-content').find('.class-fields').hide();
                    } else {
                        $(this).closest('.modal-content').find('.event-fields').hide();
                        $(this).closest('.modal-content').find('.class-fields').show();
                    }
                });
            
               
                // Add button and to load subjects start
                $('.add-btn').click(function() {
                    $('#addClassId').val($(this).data('class_id'));
                    $('#addClass').val($(this).data('class'));
                    $('#addPeriodId').val($(this).data('section_id'));
                    $('#addPeriod').val($(this).data('period'));
                    $('#addDay').val($(this).data('day'));
                    
                    // Reset form
                    $('#addForm')[0].reset();
                    $('#addType').val('class').trigger('change');
                    
                    // Show loading state
                    $('#addTeacher').html('<option value="">Select Subject First</option>');
                    $('#addSubject').html('<option value="">Loading subjects...</option>');
                    
                    // Fetch subjects via AJAX
                    $.ajax({
                        url: "{{ route('admin.timetable.create.schedule') }}",
                        method: "GET",
                        success: function(response) {
                            // Populate subjects dropdown
                            var subjectOptions = '<option value="">Select Subject</option>';
                            $.each(response.subjects, function(key, subject) {
                                subjectOptions += '<option value="' + subject.id + '">' + subject.name + ' (' + subject.code + ')</option>';
                            });
                            $('#addSubject').html(subjectOptions);
                            
                            // Show the modal after data is loaded
                            $('#addModal').modal('show');
                        },
                        error: function(xhr) {
                            // Handle error case
                            $('#addSubject').html('<option value="">Error loading subjects</option>');
                            $('#addModal').modal('show');
                            console.error('Error fetching data:', xhr.responseText);
                        }
                    });
                });      // Add button and to load subjects end
    
            
                
            
                // View button click handler
                $('.view-btn').click(function() {
                    $('#viewClass').text($(this).data('class'));
                    $('#viewPeriod').text($(this).data('period'));
                    $('#viewDay').text($(this).data('day'));
                    
                    if ($(this).data('event')) {
                        // Hide class fields and show event fields
                        $('.dynamic-display.class-fields').hide();
                        $('.dynamic-display.event-fields').show();
                        $('#viewEvent').text($(this).data('event'));
                        
                        // Update time and room fields
                        $('#viewStart').text($(this).data('start'));
                        $('#viewEnd').text($(this).data('end'));
                        $('#viewRoom').text($(this).data('room'));
                    } else {
                        // Show class fields and hide event fields
                        $('.dynamic-display.class-fields').show();
                        $('.dynamic-display.event-fields').hide();
                        $('#viewTeacher').text($(this).data('teacher'));
                        $('#viewSubject').text($(this).data('subject'));
                        
                        // Update time and room fields
                        $('#viewStart').text($(this).data('start'));
                        $('#viewEnd').text($(this).data('end'));
                        $('#viewRoom').text($(this).data('room'));
                    }
                    $('#viewStart').text($(this).data('start'));
                    $('#viewEnd').text($(this).data('end'));
                    $('#viewRoom').text($(this).data('room'));
                    
                    $('#viewModal').modal('show');
                });
            
                // Save Add button click handler
                $('#saveAdd').click(function() {
                    if (!validateScheduleTimes($('#addForm'))) {
                        return;
                    }

                    var formData = $('#addForm').serialize();

                    $.ajax({
                        url: "{{ route('admin.timetable.store.schedule') }}",
                        method: 'POST',
                        data: formData,
                        success: function() {
                            $('#addModal').modal('hide');
                            location.reload();
                        },
                        error: showScheduleError
                    });
                });
            
                // Save Update button click handler
                $('#saveUpdate').click(function() {
                    if (!validateScheduleTimes($('#updateForm'))) {
                        return;
                    }

                    var formData = $('#updateForm').serialize();

                    $.ajax({
                        url: "{{ route('admin.timetable.update.schedule') }}",
                        method: 'POST',
                        data: formData,
                        success: function() {
                            $('#updateModal').modal('hide');
                            location.reload();
                        },
                        error: showScheduleError
                    });
                });


                
            });
            // Function to fetch teachers based on selected subject in modal
            function fetchModalTeachers(selectElement) {
                 const subjectId = selectElement.value;
                 const classId = $('#addClassId').val();
                 const teacherSelect = $('#addTeacher');
                 
                 if (!subjectId || !classId) {
                     teacherSelect.html('<option value="">Select Subject First</option>');
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
                             // Add assigned teachers first
 
                             response.teachers.forEach(function(teacher) {
                                 // Mark the assigned teacher as selected if available
                                 
                                 const selected = (response.assigned_teacher_id && teacher.id == response.assigned_teacher_id) ? 'selected' : '';
                                 const employeeId = (teacher.teacher_profile && teacher.teacher_profile.employee_id) 
                                     ? teacher.teacher_profile.employee_id 
                                     : 'N/A';
                                 
                                 options += `<option value="${teacher.id}" ${selected}>${teacher.name} (${employeeId})</option>`;
                             });
                         }
                         
                         // Also include all teachers as options
                         @foreach($teachers as $teacher)
                             if (!options.includes(`value="{{ $teacher->id }}"`)) {
                                 const employeeId = "{{ $teacher->teacherProfile && $teacher->teacherProfile->employee_id ? $teacher->teacherProfile->employee_id : 'N/A' }}";
                                 options += `<option value="{{ $teacher->id }}">{{ $teacher->name }} (${employeeId})</option>`;
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

             // Function to fetch teachers for update modal
                function fetchUpdateTeachers(selectElement) {
                    const subjectId = selectElement.value;
                    const classId = $('#updateClassId').val();
                    const teacherSelect = $('#updateTeacher');
                    
                    if (!subjectId || !classId) {
                        teacherSelect.html('<option value="">Select Subject First</option>');
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
                                // Add assigned teachers first
                                response.teachers.forEach(function(teacher) {
                                    // Mark the assigned teacher as selected if available
                                    const selected = (response.assigned_teacher_id && teacher.id == response.assigned_teacher_id) ? 'selected' : '';
                                    const employeeId = (teacher.teacher_profile && teacher.teacher_profile.employee_id) 
                                        ? teacher.teacher_profile.employee_id 
                                        : 'N/A';
                                    
                                    options += `<option value="${teacher.id}" ${selected}>${teacher.name} (${employeeId})</option>`;
                                });
                            }
                            
                            // Also include all teachers as options
                            @foreach($teachers as $teacher)
                                if (!options.includes(`value="{{ $teacher->id }}"`)) {
                                    const employeeId = "{{ $teacher->teacherProfile && $teacher->teacherProfile->employee_id ? $teacher->teacherProfile->employee_id : 'N/A' }}";
                                    options += `<option value="{{ $teacher->id }}">{{ $teacher->name }} (${employeeId})</option>`;
                                }
                            @endforeach
                            
                            teacherSelect.html(options);
                            
                            // If there was a previously selected teacher, try to maintain that selection
                            const currentTeacherId = $('#updateTeacher').data('current-teacher-id');
                            if (currentTeacherId) {
                                $('#updateTeacher').val(currentTeacherId);
                            }
                        },
                        error: function(xhr) {
                            console.error(xhr);
                            teacherSelect.html('<option value="">Error loading teachers</option>');
                        }
                    });
                }

                $(document).ready(function(){

                    // Update button click handler
                    $('.update-btn').click(function() {
                        $('#updateEntryId').val($(this).data('entry-id'));
                        $('#updateClass').val($(this).data('class'));
                        $('#updateClassId').val($(this).data('class_id'));
                        $('#updatePeriod').val($(this).data('period'));
                        $('#updateDay').val($(this).data('day'));
                        $('#updateSectionId').val($(this).data('section_id'));
                        $('#updateStart').val($(this).data('start'));
                        $('#updateEnd').val($(this).data('end'));
                        $('#updateRoom').val($(this).data('room'));
                        $('#updateStart').trigger('change');

                        if ($(this).data('event')) {
                            $('#updateType').val('event').trigger('change');
                            $('#updateEvent').val($(this).data('event'));
                        } else {
                            $('#updateType').val('class').trigger('change');
                            $('#updateSubject').val($(this).data('subject_id'));
                            $('#updateTeacher').data('current-teacher-id', $(this).data('teacher_id'));
                            fetchUpdateTeachers(document.getElementById('updateSubject'));
                        }

                        $('#updateModal').modal('show');
                    });
    

                      // Update button click handler
                // $('.update-btn').click(function() {
                //     $('#updateClass').val($(this).data('class'));
                //     $('#updatePeriod').val($(this).data('period'));
                //     $('#updateDay').val($(this).data('day'));
                    
                //     if ($(this).data('event')) {
                //         $('#updateType').val('event').trigger('change');
                //         $('#updateEvent').val($(this).data('event'));
                //     } else {
                //         $('#updateType').val('class').trigger('change');
                //         $('#updateTeacher').val($(this).data('teacher'));
                //         $('#updateSubject').val($(this).data('subject'));
                //     }
                    
                //     $('#updateStart').val($(this).data('start'));
                //     $('#updateEnd').val($(this).data('end'));
                //     $('#updateRoom').val($(this).data('room'));
                    
                //     $('#updateModal').modal('show');
                // });
            
                    // Handle type change in update modal
                    $('#updateType').change(function() {
                        if ($(this).val() === 'event') {
                            $('.event-fields').show();
                            $('.class-fields').hide();
                        } else {
                            $('.event-fields').hide();
                            $('.class-fields').show();
                        }
                    });
                });

            </script>
    @endpush
</x-tenant-app-layout>