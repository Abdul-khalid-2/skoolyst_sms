<x-tenant-app-layout>
    @push('css')
        <link rel="stylesheet" href="{{ asset('backend/css/data-table/bootstrap-table.css') }}">
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

                <x-page-header title="Exam Results Report">
                    <a href="javascript:window.print()" style="color:#333;"><i class="fa fa-print"></i> Print</a>
                    <a href="#" style="color:#333;"><i class="fa fa-file-excel-o"></i> Export Excel</a>
                    <a href="{{ route('reports.index') }}" style="color:#333;"><i class="fa fa-th-large"></i> All Reports</a>
                </x-page-header>

                <div class="col-lg-12">
                    <form method="GET" action="{{ route('reports.exams') }}">
                        <div class="filter-card">
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label>Exam</label>
                                        <select name="exam_id" class="form-control input-sm">
                                            <option value="">-- Select Exam --</option>
                                            @foreach($exams as $exam)
                                                <option value="{{ $exam->id }}" {{ $selectedExam == $exam->id ? 'selected' : '' }}>{{ $exam->name }}</option>
                                            @endforeach
                                        </select>
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
                                        <label>&nbsp;</label>
                                        <div style="display:flex; gap:6px;">
                                            <button type="submit" class="btn btn-primary btn-sm btn-block"><i class="fa fa-search"></i> Generate</button>
                                            <a href="{{ route('reports.exams') }}" class="btn btn-default btn-sm" title="Reset"><i class="fa fa-refresh"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12"><div class="rep-stat" style="border-top:3px solid #3498db;"><p>Results</p><h2>{{ number_format($summary['results']) }}</h2></div></div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12"><div class="rep-stat" style="border-top:3px solid #27ae60;"><p>Pass Rate</p><h2>{{ $summary['pass_pct'] }}%</h2></div></div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12"><div class="rep-stat" style="border-top:3px solid #e74c3c;"><p>Fail Rate</p><h2>{{ $summary['fail_pct'] }}%</h2></div></div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12"><div class="rep-stat" style="border-top:3px solid #f39c12;"><p>Average Marks</p><h2>{{ $summary['avg'] }}</h2></div></div>

                <div class="col-lg-7">
                    <div class="sparkline13-list">
                        <div class="sparkline13-hd"><div class="main-sparkline13-hd"><h1>Subject-wise Performance</h1></div></div>
                        <div class="sparkline13-graph">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr><th>Subject</th><th>Avg Marks</th><th>Highest</th><th>Lowest</th><th>Pass %</th></tr>
                                    </thead>
                                    <tbody>
                                        @forelse($bySubject as $row)
                                            <tr>
                                                <td><strong>{{ $row->name }}</strong></td>
                                                <td>{{ $row->avg_marks }}</td>
                                                <td style="color:#27ae60;">{{ $row->highest }}</td>
                                                <td style="color:#e74c3c;">{{ $row->lowest }}</td>
                                                <td>{{ $row->pass_pct }}%</td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="5" class="text-center text-muted" style="padding:30px;">
                                                <i class="fa fa-bar-chart fa-2x" style="color:#ddd;"></i><br>Select an exam to view data.
                                            </td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="sparkline13-list">
                        <div class="sparkline13-hd"><div class="main-sparkline13-hd"><h1>Grade Distribution</h1></div></div>
                        <div class="sparkline13-graph">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead><tr><th>Grade</th><th>Students</th><th>%</th></tr></thead>
                                    <tbody>
                                        @forelse($gradeDist as $g)
                                            <tr>
                                                <td><strong>{{ $g->grade }}</strong></td>
                                                <td>{{ $g->cnt }}</td>
                                                <td>{{ $g->pct }}%</td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="3" class="text-center text-muted" style="padding:30px;">No data.</td></tr>
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
</x-tenant-app-layout>
