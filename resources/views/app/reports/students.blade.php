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

                <x-page-header title="Student Report">
                    <a href="javascript:window.print()" style="color:#333;"><i class="fa fa-print"></i> Print</a>
                    <a href="#" style="color:#333;"><i class="fa fa-file-excel-o"></i> Export Excel</a>
                    <a href="{{ route('reports.index') }}" style="color:#333;"><i class="fa fa-th-large"></i> All Reports</a>
                </x-page-header>

                {{-- Filters --}}
                <div class="col-lg-12">
                    <form method="GET" action="{{ route('reports.students') }}">
                        <div class="filter-card">
                            <div class="row">
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
                                        <label>Gender</label>
                                        <select name="gender" class="form-control input-sm">
                                            <option value="">All</option>
                                            <option value="male"   {{ request('gender') === 'male'   ? 'selected' : '' }}>Male</option>
                                            <option value="female" {{ request('gender') === 'female' ? 'selected' : '' }}>Female</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select name="status" class="form-control input-sm">
                                            <option value="">All</option>
                                            <option value="active"   {{ request('status') === 'active'   ? 'selected' : '' }}>Active</option>
                                            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label>&nbsp;</label>
                                        <div style="display:flex; gap:6px;">
                                            <button type="submit" class="btn btn-primary btn-sm btn-block"><i class="fa fa-search"></i> Generate</button>
                                            <a href="{{ route('reports.students') }}" class="btn btn-default btn-sm" title="Reset"><i class="fa fa-refresh"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                {{-- Summary --}}
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12"><div class="rep-stat" style="border-top:3px solid #3498db;"><p>Total Students</p><h2>{{ number_format($summary['total']) }}</h2></div></div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12"><div class="rep-stat" style="border-top:3px solid #2980b9;"><p>Male</p><h2>{{ number_format($summary['male']) }}</h2></div></div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12"><div class="rep-stat" style="border-top:3px solid #e84393;"><p>Female</p><h2>{{ number_format($summary['female']) }}</h2></div></div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12"><div class="rep-stat" style="border-top:3px solid #27ae60;"><p>Active</p><h2>{{ number_format($summary['active']) }}</h2></div></div>

                {{-- Table --}}
                <div class="col-lg-12">
                    <div class="sparkline13-list">
                        <div class="sparkline13-hd"><div class="main-sparkline13-hd"><h1>Enrolment by Class</h1></div></div>
                        <div class="sparkline13-graph">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Class</th>
                                            <th>Sections</th>
                                            <th>Male</th>
                                            <th>Female</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($byClass as $row)
                                            <tr>
                                                <td><strong>{{ $classNames[$row->class_id] ?? 'Unassigned' }}</strong></td>
                                                <td>{{ $sectionCounts[$row->class_id] ?? 0 }}</td>
                                                <td>{{ $row->male }}</td>
                                                <td>{{ $row->female }}</td>
                                                <td><strong>{{ $row->total }}</strong></td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center text-muted" style="padding:30px;">
                                                    <i class="fa fa-bar-chart fa-2x" style="color:#ddd;"></i>
                                                    <br>No students match the selected filters.
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
</x-tenant-app-layout>
