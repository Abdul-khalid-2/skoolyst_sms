<x-tenant-app-layout>
    @push('css')
        <link rel="stylesheet" href="{{ asset('backend/css/data-table/bootstrap-table.css') }}">
        <style>
            .grade-A  { color:#27ae60; font-weight:700; }
            .grade-B  { color:#3498db; font-weight:700; }
            .grade-C  { color:#f39c12; font-weight:700; }
            .grade-D  { color:#e67e22; font-weight:700; }
            .grade-F  { color:#e74c3c; font-weight:700; }
            .pct-bar  { height:6px; border-radius:3px; background:#ecf0f1; margin-top:4px; }
            .pct-fill { height:6px; border-radius:3px; }
        </style>
    @endpush
    <x-slot name="header"></x-slot>

    <div class="data-table-area mg-b-15">
        <div class="container-fluid">
            <div class="row">

                <x-page-header title="Results — {{ $exam->name }}">
                    <a href="{{ route('exams.results.enter', $exam) }}" style="color:#333;"><i class="fa fa-pencil"></i> Enter / Update Marks</a>
                    <a href="{{ route('exams.show', $exam) }}" style="color:#333;"><i class="fa fa-calendar"></i> View Schedule</a>
                </x-page-header>

                {{-- Summary --}}
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <div style="background:#fff;border:1px solid #e0e0e0;border-radius:6px;padding:14px 18px;margin-bottom:16px;border-top:3px solid #3498db;text-align:center;">
                        <p style="margin:0;font-size:12px;color:#888;">Total Results</p>
                        <h3 style="margin:4px 0;">{{ $total }}</h3>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <div style="background:#fff;border:1px solid #e0e0e0;border-radius:6px;padding:14px 18px;margin-bottom:16px;border-top:3px solid #27ae60;text-align:center;">
                        <p style="margin:0;font-size:12px;color:#888;">Passed</p>
                        <h3 style="margin:4px 0;color:#27ae60;">{{ $passed }}</h3>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <div style="background:#fff;border:1px solid #e0e0e0;border-radius:6px;padding:14px 18px;margin-bottom:16px;border-top:3px solid #e74c3c;text-align:center;">
                        <p style="margin:0;font-size:12px;color:#888;">Failed</p>
                        <h3 style="margin:4px 0;color:#e74c3c;">{{ $failed }}</h3>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <div style="background:#fff;border:1px solid #e0e0e0;border-radius:6px;padding:14px 18px;margin-bottom:16px;border-top:3px solid #f39c12;text-align:center;">
                        <p style="margin:0;font-size:12px;color:#888;">Avg Marks</p>
                        <h3 style="margin:4px 0;">{{ round($avgMarks ?? 0, 1) }}</h3>
                    </div>
                </div>

                {{-- Filter Bar --}}
                <div class="col-lg-12">
                    <form method="GET" action="{{ route('exams.results.index', $exam) }}">
                        <div style="background:#fff; border:1px solid #e0e0e0; border-radius:6px; padding:14px 18px; margin-bottom:20px;">
                            <div class="row">
                                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                    <div class="form-group" style="margin-bottom:0;">
                                        <label style="font-size:13px; font-weight:600;">Class</label>
                                        <select name="class_id" class="form-control input-sm">
                                            <option value="">All Classes</option>
                                            @foreach($classes as $class)
                                                <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                                                    {{ $class->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                    <div class="form-group" style="margin-bottom:0;">
                                        <label style="font-size:13px; font-weight:600;">Subject</label>
                                        <select name="subject_id" class="form-control input-sm">
                                            <option value="">All Subjects</option>
                                            @foreach($subjects as $subject)
                                                <option value="{{ $subject->id }}" {{ request('subject_id') == $subject->id ? 'selected' : '' }}>
                                                    {{ $subject->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12">
                                    <div class="form-group" style="margin-bottom:0;">
                                        <label style="font-size:13px; font-weight:600;">&nbsp;</label>
                                        <div style="display:flex;gap:6px;">
                                            <button type="submit" class="btn btn-primary btn-sm btn-block">
                                                <i class="fa fa-search"></i> Filter
                                            </button>
                                            <a href="{{ route('exams.results.index', $exam) }}" class="btn btn-default btn-sm" title="Reset">
                                                <i class="fa fa-refresh"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                {{-- Results Table --}}
                <div class="col-lg-12">
                    <div class="sparkline13-list">
                        <div class="sparkline13-graph">
                            <div class="datatable-dashv1-list custom-datatable-overright">
                                <div style="padding:8px 0 10px; color:#777; font-size:13px;">
                                    Showing {{ $results->firstItem() ?? 0 }}–{{ $results->lastItem() ?? 0 }} of {{ $results->total() }} results
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered hover-table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Student</th>
                                                <th>Subject</th>
                                                <th>Marks</th>
                                                <th>Grade</th>
                                                <th>Status</th>
                                                <th>Remarks</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($results as $i => $result)
                                            <tr>
                                                <td>{{ $results->firstItem() + $i }}</td>
                                                <td>{{ $result->student?->name ?? 'N/A' }}</td>
                                                <td>{{ $result->subject?->name ?? 'N/A' }}</td>
                                                <td><strong>{{ $result->marks_obtained ?? '—' }}</strong></td>
                                                <td>
                                                    @php
                                                        $gc = ['A+'=>'success','A'=>'success','B'=>'info','C'=>'warning','D'=>'warning','F'=>'danger'];
                                                    @endphp
                                                    <span class="label label-{{ $gc[$result->grade] ?? 'default' }}">
                                                        {{ $result->grade ?? '—' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @if(($result->marks_obtained ?? 0) >= 40)
                                                        <span class="label label-success">Pass</span>
                                                    @else
                                                        <span class="label label-danger">Fail</span>
                                                    @endif
                                                </td>
                                                <td>{{ $result->remarks ?? '—' }}</td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="7" class="text-center text-muted" style="padding:40px;">
                                                    <i class="fa fa-bar-chart fa-3x" style="color:#ddd;"></i>
                                                    <br><br>No results found.
                                                    @if(request()->hasAny(['class_id','subject_id']))
                                                        <br><a href="{{ route('exams.results.index', $exam) }}">Clear filters</a>
                                                    @else
                                                        <br><a href="{{ route('exams.results.enter', $exam) }}">Enter marks now</a>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                @if($results->hasPages())
                                    <div style="margin-top:15px;">{{ $results->links() }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    @push('js')
        <script src="{{ asset('backend/js/data-table/bootstrap-table.js') }}"></script>
        <script src="{{ asset('backend/js/data-table/data-table-active.js') }}"></script>
    @endpush
</x-tenant-app-layout>
