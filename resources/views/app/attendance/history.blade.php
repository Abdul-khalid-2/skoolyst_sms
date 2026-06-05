<x-tenant-app-layout>
    @push('css')
        <link rel="stylesheet" href="{{ asset('backend/css/data-table/bootstrap-table.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/datapicker/datepicker3.css') }}">
        <style>
            .filter-card {
                background: #fff;
                border: 1px solid #e0e0e0;
                border-radius: 6px;
                padding: 18px 20px;
                margin-bottom: 20px;
            }
            .filter-card label { font-weight: 600; font-size: 13px; color: #555; }

            .stat-pill {
                display: inline-block;
                padding: 2px 9px;
                border-radius: 20px;
                font-size: 12px;
                font-weight: 600;
            }
            .stat-pill.present { background: #e6f9ee; color: #27ae60; }
            .stat-pill.absent  { background: #fdecea; color: #e74c3c; }
            .stat-pill.late    { background: #fff8e1; color: #f39c12; }

            .pct-bar { height: 6px; border-radius: 3px; background: #ecf0f1; margin-top: 4px; }
            .pct-bar-fill { height: 6px; border-radius: 3px; }

            .summary-box {
                background: #fff;
                border: 1px solid #e0e0e0;
                border-radius: 6px;
                padding: 16px 20px;
                text-align: center;
                margin-bottom: 20px;
            }
            .summary-box h2 { margin: 4px 0; font-size: 28px; font-weight: 700; }
            .summary-box p  { margin: 0; font-size: 13px; color: #777; }
            .summary-box.green  { border-top: 3px solid #27ae60; }
            .summary-box.blue   { border-top: 3px solid #3498db; }
            .summary-box.red    { border-top: 3px solid #e74c3c; }
            .summary-box.orange { border-top: 3px solid #f39c12; }
        </style>
    @endpush

    <x-slot name="header"></x-slot>

    <div class="data-table-area mg-b-15">
        <div class="container-fluid">
            <div class="row">

                <x-page-header title="Attendance History">
                    <a href="{{ route('admin.attendance.create') }}" style="color:#333;">
                        <i class="fa fa-plus"></i> Take Attendance
                    </a>
                    <a href="{{ route('admin.attendance.index') }}" style="color:#333;">
                        <i class="fa fa-tachometer"></i> Dashboard
                    </a>
                </x-page-header>

                {{-- ── Summary Cards ──────────────────────────── --}}
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <div class="summary-box green">
                        <p>Total Sessions</p>
                        <h2>{{ $total }}</h2>
                        <p>All time</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <div class="summary-box blue">
                        <p>Avg Attendance</p>
                        <h2>{{ $avgPct }}%</h2>
                        <p>Last 30 days</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <div class="summary-box red">
                        <p>Highest Absent Day</p>
                        <h2>{{ $maxAbsentDay }}</h2>
                        <p>Students absent</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <div class="summary-box orange">
                        <p>Submitted Sessions</p>
                        <h2>{{ $submitted }}</h2>
                        <p>Draft: {{ $draft }}</p>
                    </div>
                </div>

                {{-- ── Filters ────────────────────────────────── --}}
                <div class="col-lg-12">
                    <form method="GET" action="{{ route('admin.attendance.history') }}">
                        <div class="filter-card">
                            <div class="row">
                                <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label>From Date</label>
                                        <input type="text" name="from_date" class="form-control input-sm datepicker"
                                            placeholder="YYYY-MM-DD"
                                            value="{{ request('from_date') }}">
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label>To Date</label>
                                        <input type="text" name="to_date" class="form-control input-sm datepicker"
                                            placeholder="YYYY-MM-DD"
                                            value="{{ request('to_date') }}">
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label>Class</label>
                                        <select name="class_id" id="filter_class_id" class="form-control input-sm">
                                            <option value="">All Classes</option>
                                            @foreach($classes as $class)
                                                <option value="{{ $class->id }}"
                                                    {{ request('class_id') == $class->id ? 'selected' : '' }}>
                                                    {{ $class->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label>Section</label>
                                        <select name="section_id" id="filter_section_id" class="form-control input-sm">
                                            <option value="">All Sections</option>
                                            {{-- Pre-populate when filter is active --}}
                                            @if(request('class_id') && request('section_id'))
                                                @foreach($sections as $section)
                                                    <option value="{{ $section->id }}" selected>
                                                        {{ $section->name }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select name="status" class="form-control input-sm">
                                            <option value="">All</option>
                                            <option value="submitted" {{ request('status') === 'submitted' ? 'selected' : '' }}>Submitted</option>
                                            <option value="draft"     {{ request('status') === 'draft'     ? 'selected' : '' }}>Draft</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label>&nbsp;</label>
                                        <div style="display:flex; gap:6px;">
                                            <button type="submit" class="btn btn-primary btn-sm btn-block">
                                                <i class="fa fa-search"></i> Filter
                                            </button>
                                            <a href="{{ route('admin.attendance.history') }}" class="btn btn-default btn-sm" title="Reset">
                                                <i class="fa fa-refresh"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                {{-- ── History Table ──────────────────────────── --}}
                <div class="col-lg-12">
                    <div class="sparkline13-list">
                        <div class="sparkline13-graph">
                            <div class="datatable-dashv1-list custom-datatable-overright">

                                <div style="padding: 8px 0 12px; color:#777; font-size:13px;">
                                    Showing {{ $sessions->firstItem() ?? 0 }}–{{ $sessions->lastItem() ?? 0 }}
                                    of {{ $sessions->total() }} sessions
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered hover-table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Date</th>
                                                <th>Day</th>
                                                <th>Class</th>
                                                <th>Section</th>
                                                <th>Present</th>
                                                <th>Absent</th>
                                                <th>Late</th>
                                                <th>Attendance %</th>
                                                <th>Status</th>
                                                <th>Recorded By</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($sessions as $i => $session)
                                                @php
                                                    $att      = $session->attendances;
                                                    $present  = $att->where('status', 'present')->count();
                                                    $absent   = $att->where('status', 'absent')->count();
                                                    $late     = $att->where('status', 'late')->count();
                                                    $total    = $att->count();
                                                    $pct      = $total > 0 ? round(($present / $total) * 100, 1) : 0;
                                                    $barColor = $pct >= 90 ? '#27ae60' : ($pct >= 75 ? '#f39c12' : '#e74c3c');

                                                    $className   = $session->timeTable->class->name
                                                                ?? $session->schoolClass?->name
                                                                ?? 'N/A';
                                                    $sectionName = $session->timeTable->section->name
                                                                ?? $session->section?->name
                                                                ?? 'N/A';
                                                @endphp
                                                <tr>
                                                    <td>{{ $sessions->firstItem() + $i }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($session->date)->format('d M Y') }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($session->date)->format('l') }}</td>
                                                    <td><strong>{{ $className }}</strong></td>
                                                    <td>{{ $sectionName }}</td>
                                                    <td><span class="stat-pill present">{{ $present }}</span></td>
                                                    <td><span class="stat-pill absent">{{ $absent }}</span></td>
                                                    <td><span class="stat-pill late">{{ $late }}</span></td>
                                                    <td>
                                                        {{ $pct }}%
                                                        <div class="pct-bar">
                                                            <div class="pct-bar-fill" style="width:{{ $pct }}%; background:{{ $barColor }};"></div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        @if($session->status === 'submitted')
                                                            <span class="label label-success">Submitted</span>
                                                        @else
                                                            <span class="label label-default">Draft</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $session->recordedBy?->name ?? 'N/A' }}</td>
                                                    <td>
                                                        <div style="display:flex; gap:4px;">
                                                            <a href="{{ route('admin.attendance.show', $session->id) }}"
                                                               class="btn btn-xs btn-success" title="View">
                                                                <i class="fa fa-eye"></i>
                                                            </a>
                                                            <a href="{{ route('admin.attendance.edit', $session->id) }}"
                                                               class="btn btn-xs btn-primary" title="Edit">
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="12" class="text-center text-muted" style="padding:30px;">
                                                        <i class="fa fa-calendar-o fa-2x"></i><br>
                                                        No attendance records found.
                                                        @if(request()->hasAny(['from_date','to_date','class_id','section_id','status']))
                                                            <br><a href="{{ route('admin.attendance.history') }}">Clear filters</a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                {{-- Pagination --}}
                                @if($sessions->hasPages())
                                    <div style="margin-top:15px;">
                                        {{ $sessions->links() }}
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    @push('js')
        <script src="{{ asset('backend/js/editable/moment.min.js') }}"></script>
        <script>
        $(document).ready(function () {

            if ($.fn.datepicker) {
                $('.datepicker').datepicker({ format: 'yyyy-mm-dd', autoclose: true });
            }

            var $classSelect   = $('#filter_class_id');
            var $sectionSelect = $('#filter_section_id');
            var preselectedSection = '{{ request('section_id') }}';

            function loadSections(classId, selectedId) {
                $sectionSelect.html('<option value="">Loading...</option>').prop('disabled', true);

                if (!classId) {
                    $sectionSelect.html('<option value="">All Sections</option>').prop('disabled', false);
                    return;
                }

                $.ajax({
                    url: '{{ route('attendance.get-sections') }}',
                    type: 'GET',
                    data: { class_id: classId },
                    success: function (response) {
                        var options = '<option value="">All Sections</option>';
                        $.each(response.sections, function (i, section) {
                            var sel = (selectedId && selectedId == section.id) ? 'selected' : '';
                            options += '<option value="' + section.id + '" ' + sel + '>' + section.name + '</option>';
                        });
                        $sectionSelect.html(options).prop('disabled', false);
                    },
                    error: function () {
                        $sectionSelect.html('<option value="">All Sections</option>').prop('disabled', false);
                    }
                });
            }

            // On class change — load sections, clear previous section selection
            $classSelect.on('change', function () {
                loadSections($(this).val(), null);
            });

            // On page load with an active class filter — reload sections and reselect
            var initialClass = $classSelect.val();
            if (initialClass && preselectedSection) {
                loadSections(initialClass, preselectedSection);
            } else if (initialClass) {
                loadSections(initialClass, null);
            }

        });
        </script>
    @endpush

</x-tenant-app-layout>
