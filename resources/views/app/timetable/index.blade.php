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
                                                                data-class="{{ $timetable['class_name'] }}"
                                                                data-class_id="{{ $timetable['class_id'] }}"
                                                                data-period="{{ $periodName }}"
                                                                data-day="{{ $day }}"
                                                                data-section_id="{{ $timetable['section_id'] }}"
                                                                data-teacher="{{ $days[$day]['teacher'] ?? '' }}"
                                                                data-teacher_id="{{ $days[$day]['teacher_id'] ?? '' }}"
                                                                data-subject="{{ $days[$day]['subject'] ?? '' }}"
                                                                data-subject_id="{{ $days[$day]['subject_id'] ?? '' }}"
                                                                data-start="{{ $days[$day]['start'] ?? '' }}"
                                                                data-end="{{ $days[$day]['end'] ?? '' }}"
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
                        <input type="time" class="form-control" name="start" id="addStart">
                    </div>
                    
                    <div class="form-group">
                        <label>End Time</label>
                        <input type="time" class="form-control" name="end" id="addEnd">
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
                        <input type="time" class="form-control" name="start" id="updateStart">
                    </div>
                    
                    <div class="form-group">
                        <label>End Time</label>
                        <input type="time" class="form-control" name="end" id="updateEnd">
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
                    // Here you would typically make an AJAX call to save the data
                    var formData = $('#addForm').serialize();
                    
                    console.log(formData);
                    
                    $.ajax({
                        url: "{{ route('admin.timetable.store.schedule') }}",
                        method: 'POST',
                        data: formData,
                        success: function(response) {
                            $('#addModal').modal('hide');
                            location.reload(); 
                        },
                        error: function(xhr) {
                            alert('Error: ' + xhr.responseText);
                        }
                    });
                    
                    $('#addModal').modal('hide');
                    alert('Time table schedule added successfully');
                });
            
                // Save Update button click handler
                $('#saveUpdate').click(function() {
                    // Here you would typically make an AJAX call to update the data
                    var formData = $('#updateForm').serialize();
                    
                    // Example AJAX call (you'll need to implement the server-side part)
                    /*
                    $.ajax({
                        url: '/timetable/update',
                        method: 'POST',
                        data: formData,
                        success: function(response) {
                            $('#updateModal').modal('hide');
                            location.reload(); // Refresh the page to see changes
                        },
                        error: function(xhr) {
                            alert('Error: ' + xhr.responseText);
                        }
                    });
                    */
                    
                    // For demo purposes, just close the modal
                    $('#updateModal').modal('hide');
                    alert('Update functionality would save here. Form data: ' + formData);
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
                        $('#updateClass').val($(this).data('class'));
                        $('#updateClassId').val($(this).data('class_id'));
                        $('#updatePeriod').val($(this).data('period'));
                        $('#updateDay').val($(this).data('day'));
                        $('#updateSectionId').val($(this).data('section_id'));
                        
                        if ($(this).data('event')) {
                            $('#updateType').val('event').trigger('change');
                            $('#updateEvent').val($(this).data('event'));
                        } else {
                            $('#updateType').val('class').trigger('change');
                            
                            // Set subject and store the current teacher ID
                            $('#updateSubject').val($(this).data('subject_id'));
                            $('#updateTeacher').data('current-teacher-id', $(this).data('teacher_id'));
                           
                            
                            // Trigger teacher fetch based on selected subject
                            fetchUpdateTeachers(document.getElementById('updateSubject'));
                            
                            // Set other values
                            $('#updateStart').val($(this).data('start'));
                            $('#updateEnd').val($(this).data('end'));
                            $('#updateRoom').val($(this).data('room'));
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