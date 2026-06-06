<x-tenant-app-layout>
    @push('css')
        <link rel="stylesheet" href="{{ asset('backend/css/data-table/bootstrap-table.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/datapicker/datepicker3.css') }}">
        <style>
            .filter-card { background:#fff; border:1px solid #e0e0e0; border-radius:6px; padding:16px 20px; margin-bottom:20px; }
            .filter-card label { font-weight:600; font-size:13px; color:#555; }
            .rep-stat { background:#fff; border:1px solid #e0e0e0; border-radius:6px; padding:16px 20px; margin-bottom:20px; text-align:center; }
            .rep-stat h2 { margin:4px 0; font-size:24px; font-weight:700; }
            .rep-stat p  { margin:0; font-size:12px; color:#888; }
        </style>
    @endpush
    <x-slot name="header"></x-slot>

    <div class="data-table-area mg-b-15">
        <div class="container-fluid">
            <div class="row">

                <x-page-header title="Attendance Report">
                    <a href="javascript:window.print()" style="color:#333;"><i class="fa fa-print"></i> Print</a>
                    <a href="#" style="color:#333;"><i class="fa fa-file-excel-o"></i> Export Excel</a>
                    <a href="{{ route('reports.index') }}" style="color:#333;"><i class="fa fa-th-large"></i> All Reports</a>
                </x-page-header>

                <div class="col-lg-12">
                    <form method="GET" action="{{ route('reports.attendance') }}">
                        <div class="filter-card">
                            <div class="row">
                                <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label>From Date</label>
                                        <input type="text" name="from_date" class="form-control input-sm datepicker" placeholder="YYYY-MM-DD" value="{{ request('from_date') }}">
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label>To Date</label>
                                        <input type="text" name="to_date" class="form-control input-sm datepicker" placeholder="YYYY-MM-DD" value="{{ request('to_date') }}">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label>Class</label>
                                        <select name="class_id" class="form-control input-sm">
                                            <option value="">All Classes</option>
                                            @foreach($classes as $class)
                                                <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label>Section</label>
                                        <select name="section_id" class="form-control input-sm">
                                            <option value="">All Sections</option>
                                            @foreach($sections as $section)
                                                <option value="{{ $section->id }}" {{ request('section_id') == $section->id ? 'selected' : '' }}>{{ $section->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label>&nbsp;</label>
                                        <div style="display:flex; gap:6px;">
                                            <button type="submit" class="btn btn-primary btn-sm btn-block"><i class="fa fa-search"></i> Generate</button>
                                            <a href="{{ route('reports.attendance') }}" class="btn btn-default btn-sm" title="Reset"><i class="fa fa-refresh"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12"><div class="rep-stat" style="border-top:3px solid #3498db;"><p>Sessions</p><h2>{{ number_format($summary['sessions']) }}</h2></div></div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12"><div class="rep-stat" style="border-top:3px solid #27ae60;"><p>Present %</p><h2>{{ $summary['present_pct'] }}%</h2></div></div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12"><div class="rep-stat" style="border-top:3px solid #e74c3c;"><p>Absent %</p><h2>{{ $summary['absent_pct'] }}%</h2></div></div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12"><div class="rep-stat" style="border-top:3px solid #f39c12;"><p>Late %</p><h2>{{ $summary['late_pct'] }}%</h2></div></div>

                <div class="col-lg-12">
                    <div class="sparkline13-list">
                        <div class="sparkline13-hd"><div class="main-sparkline13-hd"><h1>Attendance by Class</h1></div></div>
                        <div class="sparkline13-graph">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Class</th>
                                            <th>Section</th>
                                            <th>Present</th>
                                            <th>Absent</th>
                                            <th>Late</th>
                                            <th>Attendance %</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($byClass as $row)
                                            @php $pct = $row->total ? round(($row->present / $row->total) * 100, 1) : 0; @endphp
                                            <tr>
                                                <td><strong>{{ $classNames[$row->class_id] ?? 'N/A' }}</strong></td>
                                                <td>{{ $sectionNames[$row->section_id] ?? 'All' }}</td>
                                                <td>{{ $row->present }}</td>
                                                <td>{{ $row->absent }}</td>
                                                <td>{{ $row->late }}</td>
                                                <td><strong style="color:{{ $pct >= 90 ? '#27ae60' : ($pct >= 75 ? '#f39c12' : '#e74c3c') }};">{{ $pct }}%</strong></td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center text-muted" style="padding:30px;">
                                                    <i class="fa fa-calendar-check-o fa-2x" style="color:#ddd;"></i>
                                                    <br>No attendance records match the selected filters.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    @push('js')
        <script>
        $(document).ready(function () {
            if ($.fn.datepicker) { $('.datepicker').datepicker({ format: 'yyyy-mm-dd', autoclose: true }); }
        });
        </script>
    @endpush
</x-tenant-app-layout>
