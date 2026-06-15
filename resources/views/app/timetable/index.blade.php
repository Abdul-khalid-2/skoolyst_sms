<x-tenant-app-layout>
    @push('css')
        <link rel="stylesheet" href="{{ asset('backend/css/editor/select2.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/editor/datetimepicker.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/editor/bootstrap-editable.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/editor/x-editor-style.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/data-table/bootstrap-table.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/data-table/bootstrap-editable.css') }}">
    <style>
        .tt-page { margin-top: 20px; }

        .tt-nav-panel {
            background: #fff;
            border: 1px solid #e3e8ef;
            border-radius: 10px;
            box-shadow: 0 2px 12px rgba(15, 23, 42, 0.06);
            position: sticky;
            top: 20px;
            max-height: calc(100vh - 100px);
            display: flex;
            flex-direction: column;
        }

        .tt-nav-head {
            padding: 16px 16px 12px;
            border-bottom: 1px solid #eef2f7;
        }

        .tt-nav-head h4 {
            margin: 0 0 10px;
            font-size: 15px;
            font-weight: 700;
            color: #1e293b;
        }

        .tt-nav-search {
            position: relative;
        }

        .tt-nav-search i {
            position: absolute;
            left: 11px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
        }

        .tt-nav-search input {
            padding-left: 34px;
            border-radius: 8px;
            border: 1px solid #dbe3ee;
            height: 38px;
        }

        .tt-nav-list {
            overflow-y: auto;
            padding: 10px;
            flex: 1;
        }

        .tt-class-group {
            margin-bottom: 12px;
        }

        .tt-class-heading {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            color: #64748b;
            padding: 6px 8px 4px;
        }

        .tt-nav-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            text-align: left;
            border: 1px solid transparent;
            background: #f8fafc;
            border-radius: 8px;
            padding: 10px 12px;
            margin-bottom: 6px;
            transition: all 0.15s ease;
            cursor: pointer;
        }

        .tt-nav-item:hover {
            background: #eff6ff;
            border-color: #bfdbfe;
        }

        .tt-nav-item.active {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            border-color: #2563eb;
            color: #fff;
            box-shadow: 0 4px 14px rgba(37, 99, 235, 0.25);
        }

        .tt-nav-item.active .tt-nav-meta { color: rgba(255,255,255,0.85); }

        .tt-nav-label {
            font-weight: 600;
            font-size: 13px;
        }

        .tt-nav-meta {
            font-size: 11px;
            color: #64748b;
        }

        .tt-nav-badge {
            font-size: 11px;
            font-weight: 700;
            background: rgba(255,255,255,0.2);
            color: inherit;
            border-radius: 999px;
            padding: 2px 8px;
            min-width: 28px;
            text-align: center;
        }

        .tt-nav-item:not(.active) .tt-nav-badge {
            background: #e2e8f0;
            color: #475569;
        }

        .tt-nav-foot {
            padding: 10px 16px 14px;
            border-top: 1px solid #eef2f7;
            font-size: 12px;
            color: #64748b;
        }

        .tt-panel {
            display: none;
            animation: ttFadeIn 0.2s ease;
        }

        .tt-panel.active {
            display: block;
        }

        @keyframes ttFadeIn {
            from { opacity: 0; transform: translateY(6px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .tt-panel-card {
            background: #fff;
            border: 1px solid #e3e8ef;
            border-radius: 10px;
            box-shadow: 0 2px 12px rgba(15, 23, 42, 0.06);
            overflow: hidden;
        }

        .tt-panel-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 16px 20px;
            background: linear-gradient(135deg, #f8fafc 0%, #eff6ff 100%);
            border-bottom: 1px solid #e3e8ef;
        }

        .tt-panel-head h3 {
            margin: 0;
            font-size: 18px;
            font-weight: 700;
            color: #0f172a;
        }

        .tt-panel-head small {
            color: #64748b;
        }

        .tt-table-wrap {
            overflow-x: auto;
            padding: 0;
        }

        .tt-grid {
            width: 100%;
            margin: 0;
            border-collapse: separate;
            border-spacing: 0;
        }

        .tt-grid thead th {
            background: #f1f5f9;
            color: #334155;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.03em;
            padding: 12px 10px;
            border-bottom: 1px solid #e2e8f0;
            white-space: nowrap;
        }

        .tt-grid tbody td {
            vertical-align: top;
            padding: 8px;
            border-bottom: 1px solid #eef2f7;
            border-right: 1px solid #eef2f7;
            min-width: 130px;
        }

        .tt-grid tbody td:first-child {
            background: #f8fafc;
            font-weight: 600;
            color: #475569;
            min-width: 100px;
            position: sticky;
            left: 0;
            z-index: 1;
        }

        .tt-slot {
            background: #fff;
            border: 1px solid #dbeafe;
            border-left: 3px solid #3b82f6;
            border-radius: 8px;
            padding: 8px;
            margin-bottom: 6px;
        }

        .tt-slot--break {
            border-color: #fde68a;
            border-left-color: #f59e0b;
            background: #fffbeb;
        }

        .tt-slot--empty {
            border: 1px dashed #cbd5e1;
            border-left: 3px dashed #cbd5e1;
            background: #f8fafc;
            color: #94a3b8;
            font-size: 12px;
            padding: 12px 8px;
            text-align: center;
            margin-bottom: 6px;
        }

        .tt-slot-title {
            font-weight: 700;
            font-size: 12px;
            color: #1e293b;
            margin-bottom: 4px;
        }

        .tt-slot-meta {
            font-size: 11px;
            color: #64748b;
            line-height: 1.5;
        }

        .tt-slot-meta i {
            width: 14px;
            color: #94a3b8;
        }

        .tt-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 4px;
            margin-top: 6px;
        }

        .tt-actions .btn {
            padding: 2px 7px;
            font-size: 11px;
        }

        .tt-empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #64748b;
        }

        .tt-empty-state i {
            font-size: 42px;
            color: #cbd5e1;
            margin-bottom: 12px;
        }

        @media (max-width: 991px) {
            .tt-nav-panel {
                position: static;
                max-height: none;
                margin-bottom: 20px;
            }

            .tt-nav-list {
                max-height: 260px;
            }
        }
    </style>
@endpush
    <x-slot name="header"></x-slot>
    
    <div class="data-table-area mg-b-15">
        <div class="container-fluid">
            <div class="row">
                <x-page-header
                    title="All Classes Timetable"
                    :add-route="route('admin.timetable.create')"
                    add-label="Add Timetable"
                />


                @php
                    $groupedTimetables = collect($timetables)->groupBy('class_id');
                    $totalSections = count($timetables);
                @endphp

                <div class="col-lg-12 tt-page">
                    @if($totalSections === 0)
                        <div class="tt-panel-card">
                            <div class="tt-empty-state">
                                <i class="fa fa-calendar-o"></i>
                                <h4>No timetables yet</h4>
                                <p>Add a schedule using the button above to get started.</p>
                            </div>
                        </div>
                    @else
                        <div class="row">
                            {{-- Class / Section Navigator --}}
                            <div class="col-lg-3 col-md-4 col-sm-12">
                                <div class="tt-nav-panel">
                                    <div class="tt-nav-head">
                                        <h4><i class="fa fa-th-list"></i> Class &amp; Section</h4>
                                        <div class="tt-nav-search">
                                            <i class="fa fa-search"></i>
                                            <input type="text" id="ttSearch" class="form-control" placeholder="Search class or section...">
                                        </div>
                                    </div>
                                    <div class="tt-nav-list" id="ttNavList">
                                        @php $panelIndex = 0; @endphp
                                        @foreach($groupedTimetables as $classId => $sections)
                                            @php
                                                $classLabel = preg_replace('/\s*\(Section.*$/', '', $sections->first()['class_name']);
                                            @endphp
                                            <div class="tt-class-group" data-class-name="{{ strtolower($classLabel) }}">
                                                <div class="tt-class-heading">{{ $classLabel }}</div>
                                                @foreach($sections as $timetable)
                                                    @php
                                                        $slotCount = collect($timetable['periods'])->sum(fn ($days) => count($days));
                                                        preg_match('/\(Section\s(.+)\)$/', $timetable['class_name'], $sectionMatch);
                                                        $sectionLabel = $sectionMatch[1] ?? '—';
                                                        $searchText = strtolower($classLabel . ' ' . $sectionLabel);
                                                    @endphp
                                                    <button type="button"
                                                        class="tt-nav-item {{ $panelIndex === 0 ? 'active' : '' }}"
                                                        data-panel="tt-panel-{{ $panelIndex }}"
                                                        data-search="{{ $searchText }}">
                                                        <span>
                                                            <span class="tt-nav-label">Section {{ $sectionLabel }}</span>
                                                            <div class="tt-nav-meta">{{ $slotCount }} slot{{ $slotCount !== 1 ? 's' : '' }} scheduled</div>
                                                        </span>
                                                        <span class="tt-nav-badge">{{ $slotCount }}</span>
                                                    </button>
                                                    @php $panelIndex++; @endphp
                                                @endforeach
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="tt-nav-foot">
                                        <i class="fa fa-info-circle"></i>
                                        {{ $groupedTimetables->count() }} class{{ $groupedTimetables->count() !== 1 ? 'es' : '' }},
                                        {{ $totalSections }} section{{ $totalSections !== 1 ? 's' : '' }}
                                    </div>
                                </div>
                            </div>

                            {{-- Timetable Panels --}}
                            <div class="col-lg-9 col-md-8 col-sm-12">
                                @foreach($timetables as $timetable)
                                    @php
                                        preg_match('/^(.+?)\s*\(Section\s(.+)\)$/', $timetable['class_name'], $nameParts);
                                        $displayClass = $nameParts[1] ?? $timetable['class_name'];
                                        $displaySection = $nameParts[2] ?? '';
                                        $slotCount = collect($timetable['periods'])->sum(fn ($days) => count($days));
                                    @endphp
                                    <div id="tt-panel-{{ $loop->index }}" class="tt-panel {{ $loop->first ? 'active' : '' }}">
                                        <div class="tt-panel-card">
                                            <div class="tt-panel-head">
                                                <div>
                                                    <h3>{{ $displayClass }}</h3>
                                                    <small>Section {{ $displaySection }} &middot; {{ $slotCount }} scheduled slot{{ $slotCount !== 1 ? 's' : '' }}</small>
                                                </div>
                                                <span class="label label-primary" style="font-size:12px;padding:6px 12px;border-radius:20px;">
                                                    <i class="fa fa-calendar"></i> Weekly Schedule
                                                </span>
                                            </div>
                                            <div class="tt-table-wrap">
                                                <table class="tt-grid">
                                                    <thead>
                                                        <tr>
                                                            <th>Period</th>
                                                            @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $dayName)
                                                                <th>{{ $dayName }}</th>
                                                            @endforeach
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse($timetable['periods'] as $periodName => $days)
                                                            <tr>
                                                                <td>{{ $periodName }}</td>
                                                                @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                                                                    <td>
                                                                        @if(isset($days[$day]))
                                                                            @if(isset($days[$day]['event']))
                                                                                <div class="tt-slot tt-slot--break">
                                                                                    <div class="tt-slot-title"><i class="fa fa-coffee"></i> {{ $days[$day]['event'] }}</div>
                                                                                    <div class="tt-slot-meta">
                                                                                        <div><i class="fa fa-clock-o"></i> {{ $days[$day]['start'] }} – {{ $days[$day]['end'] }}</div>
                                                                                        <div><i class="fa fa-map-marker"></i> {{ $days[$day]['room'] ?: '—' }}</div>
                                                                                    </div>
                                                                                </div>
                                                                            @else
                                                                                <div class="tt-slot">
                                                                                    <div class="tt-slot-title">{{ $days[$day]['subject'] }}</div>
                                                                                    <div class="tt-slot-meta">
                                                                                        <div><i class="fa fa-user"></i> {{ $days[$day]['teacher'] }}</div>
                                                                                        <div><i class="fa fa-clock-o"></i> {{ $days[$day]['start'] }} – {{ $days[$day]['end'] }}</div>
                                                                                        <div><i class="fa fa-map-marker"></i> {{ $days[$day]['room'] ?: '—' }}</div>
                                                                                    </div>
                                                                                </div>
                                                                            @endif
                                                                            <div class="tt-actions">
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
                                                                                    <i class="fa fa-pencil"></i> Edit
                                                                                </button>
                                                                                <button class="btn btn-default btn-sm view-btn"
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
                                                                            <div class="tt-slot--empty">No schedule</div>
                                                                            <div class="tt-actions">
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
                                                        @empty
                                                            <tr>
                                                                <td colspan="8">
                                                                    <div class="tt-empty-state" style="padding:30px;">
                                                                        <i class="fa fa-calendar-plus-o"></i>
                                                                        <p>No periods defined yet. Click <strong>Add</strong> on any day to create a schedule.</p>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
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

            const sectionTeacherAssignUrl = @json(route('admin.academic.subjects.section_teacher'));

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

            function validateScheduleTimes(form) {
                var start = form.find('.schedule-start').val();
                var end = form.find('.schedule-end').val();

                if (!start || !end) {
                    showToast('warning', 'Please enter both start and end time.');
                    return false;
                }

                var startParts = start.split(':');
                var endParts = end.split(':');
                var startMinutes = (parseInt(startParts[0], 10) * 60) + parseInt(startParts[1], 10);
                var endMinutes = (parseInt(endParts[0], 10) * 60) + parseInt(endParts[1], 10);

                if (endMinutes <= startMinutes) {
                    showToast('warning', 'End time must be at least 1 minute after start time.');
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

            const classSubjects = @json($classSubjects);

            function populateSubjectsForClass(classId, selectEl, selectedId) {
                let options = '<option value="">Select Subject</option>';
                const subjects = classSubjects[classId] || [];

                if (subjects.length === 0) {
                    options += '<option value="" disabled>No subjects in class curriculum — add them in Academic Assignments</option>';
                } else {
                    subjects.forEach(function(subject) {
                        const selected = (selectedId && String(selectedId) === String(subject.id)) ? 'selected' : '';
                        options += `<option value="${subject.id}" ${selected}>${subject.name} (${subject.code})</option>`;
                    });
                }

                $(selectEl).html(options);
            }

            function showScheduleError(xhr) {
                var messages = ['Error saving schedule. Please try again.'];

                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    messages = Object.values(xhr.responseJSON.errors).flat();
                }

                var text = messages.join(' ');
                var isAllocationError = text.indexOf('Section Teacher Allocation') !== -1;

                if (typeof Swal === 'undefined') {
                    alert(text);
                    return;
                }

                if (isAllocationError) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Teacher not allocated',
                        html: '<p style="margin:0 0 14px; color:#555; font-size:14px; line-height:1.5;">' + text + '</p>' +
                              '<a href="' + sectionTeacherAssignUrl + '" class="btn btn-success btn-sm">' +
                              '<i class="fa fa-user-plus"></i> Open Section Teacher Allocation</a>',
                        confirmButtonText: 'Close',
                        confirmButtonColor: '#6366f1',
                    });
                    return;
                }

                showToast('error', text);
            }

            $(document).ready(function() {
                bindScheduleTimeValidation('#addForm');
                bindScheduleTimeValidation('#updateForm');

                // Class / section navigator
                function showTimetablePanel(panelId) {
                    $('.tt-panel').removeClass('active');
                    $('#' + panelId).addClass('active');
                    $('.tt-nav-item').removeClass('active');
                    $('.tt-nav-item[data-panel="' + panelId + '"]').addClass('active');
                    sessionStorage.setItem('tt_active_panel', panelId);
                }

                var savedPanel = sessionStorage.getItem('tt_active_panel');
                if (savedPanel && $('#' + savedPanel).length) {
                    showTimetablePanel(savedPanel);
                }

                $('.tt-nav-item').on('click', function() {
                    showTimetablePanel($(this).data('panel'));
                });

                $('#ttSearch').on('input', function() {
                    var query = $(this).val().toLowerCase().trim();
                    var visibleCount = 0;

                    $('.tt-class-group').each(function() {
                        var group = $(this);
                        var groupVisible = false;

                        group.find('.tt-nav-item').each(function() {
                            var item = $(this);
                            var searchText = item.data('search') || '';
                            var className = group.data('class-name') || '';
                            var match = !query || searchText.indexOf(query) !== -1 || className.indexOf(query) !== -1;

                            item.toggle(match);
                            if (match) {
                                groupVisible = true;
                                visibleCount++;
                            }
                        });

                        group.toggle(groupVisible);
                    });

                    if (query && visibleCount === 1) {
                        showTimetablePanel($('.tt-nav-item:visible').first().data('panel'));
                    }
                });

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
                    const classId = $(this).data('class_id');
                    const sectionId = $(this).data('section_id');

                    $('#addForm')[0].reset();
                    $('#addClassId').val(classId);
                    $('#addClass').val($(this).data('class'));
                    $('#addPeriodId').val(sectionId);
                    $('#addPeriod').val($(this).data('period'));
                    $('#addDay').val($(this).data('day'));
                    $('#addType').val('class').trigger('change');
                    
                    $('#addTeacher').html('<option value="">Select Subject First</option>');
                    $('#addSubject').html('<option value="">Loading subjects...</option>');
                    
                    $.ajax({
                        url: "{{ route('admin.timetable.create.schedule') }}",
                        method: "GET",
                        data: { class_id: classId },
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
                         class_id: classId,
                         section_id: $('#addPeriodId').val()
                     },
                     success: function(response) {
                         let options = '<option value="">Select Teacher</option>';
                         
                         if (response.teachers && response.teachers.length > 0) {
                             response.teachers.forEach(function(teacher) {
                                 const selected = (response.assigned_teacher_id && teacher.id == response.assigned_teacher_id) ? 'selected' : '';
                                 const employeeId = (teacher.teacher_profile && teacher.teacher_profile.employee_id) 
                                     ? teacher.teacher_profile.employee_id 
                                     : 'N/A';
                                 
                                 options += `<option value="${teacher.id}" ${selected}>${teacher.name} (${employeeId})</option>`;
                             });
                         } else {
                             options += '<option value="" disabled>No teachers qualified for this subject yet — assign under Teacher Capabilities</option>';
                         }
                         
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
                            class_id: classId,
                            section_id: $('#updateSectionId').val()
                        },
                        success: function(response) {
                            let options = '<option value="">Select Teacher</option>';
                            
                            if (response.teachers && response.teachers.length > 0) {
                                response.teachers.forEach(function(teacher) {
                                    const selected = (response.assigned_teacher_id && teacher.id == response.assigned_teacher_id) ? 'selected' : '';
                                    const employeeId = (teacher.teacher_profile && teacher.teacher_profile.employee_id) 
                                        ? teacher.teacher_profile.employee_id 
                                        : 'N/A';
                                    
                                    options += `<option value="${teacher.id}" ${selected}>${teacher.name} (${employeeId})</option>`;
                                });
                            } else {
                                options += '<option value="" disabled>No teachers qualified for this subject yet — assign under Teacher Capabilities</option>';
                            }
                            
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
                        const classId = $(this).data('class_id');
                        const subjectId = $(this).data('subject_id');

                        $('#updateEntryId').val($(this).data('entry-id'));
                        $('#updateClass').val($(this).data('class'));
                        $('#updateClassId').val(classId);
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
                            populateSubjectsForClass(classId, '#updateSubject', subjectId);
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