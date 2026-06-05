<x-tenant-app-layout>
    @push('css')
        <link rel="stylesheet" href="{{ asset('backend/css/data-table/bootstrap-table.css') }}">
        <style>
            .exam-stat { background:#fff; border:1px solid #e0e0e0; border-radius:6px; padding:18px 20px; margin-bottom:20px; }
            .exam-stat h2 { margin:4px 0; font-size:26px; font-weight:700; }
            .exam-stat p  { margin:0; font-size:13px; color:#777; }
            .exam-stat.blue   { border-top:3px solid #3498db; }
            .exam-stat.green  { border-top:3px solid #27ae60; }
            .exam-stat.orange { border-top:3px solid #f39c12; }
            .exam-stat.purple { border-top:3px solid #8e44ad; }
            .exam-card { background:#fff; border:1px solid #e0e0e0; border-radius:6px; padding:16px 20px; margin-bottom:16px; }
            .exam-card h4 { margin:0 0 4px; font-size:16px; font-weight:700; }
            .exam-card .meta { font-size:12px; color:#888; margin-bottom:10px; }
            .badge-published   { background:#27ae60; color:#fff; padding:3px 9px; border-radius:20px; font-size:11px; }
            .badge-unpublished { background:#95a5a6; color:#fff; padding:3px 9px; border-radius:20px; font-size:11px; }
            .badge-upcoming    { background:#3498db; color:#fff; padding:3px 9px; border-radius:20px; font-size:11px; }
            .badge-ongoing     { background:#f39c12; color:#fff; padding:3px 9px; border-radius:20px; font-size:11px; }
            .badge-completed   { background:#27ae60; color:#fff; padding:3px 9px; border-radius:20px; font-size:11px; }
        </style>
    @endpush
    <x-slot name="header"></x-slot>

    <div class="data-table-area mg-b-15">
        <div class="container-fluid">
            <div class="row">

                <x-page-header title="Exams">
                    <a href="{{ route('exams.create') }}" style="color:#333;"><i class="fa fa-plus"></i> Create Exam</a>
                </x-page-header>

                {{-- Summary Cards --}}
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <div class="exam-stat blue">
                        <p><i class="fa fa-calendar"></i> Total Exams</p>
                        <h2>{{ $total }}</h2>
                        <p>All time</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <div class="exam-stat orange">
                        <p><i class="fa fa-clock-o"></i> Upcoming</p>
                        <h2>{{ $upcoming }}</h2>
                        <p>Scheduled ahead</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <div class="exam-stat green">
                        <p><i class="fa fa-check-circle"></i> Completed</p>
                        <h2>{{ $completed }}</h2>
                        <p>Results published</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <div class="exam-stat purple">
                        <p><i class="fa fa-pencil"></i> Ongoing</p>
                        <h2>{{ $ongoing }}</h2>
                        <p>In progress today</p>
                    </div>
                </div>

                {{-- Exams List --}}
                <div class="col-lg-12">
                    <div class="sparkline13-list">
                        <div class="sparkline13-graph">
                            <div class="datatable-dashv1-list custom-datatable-overright">

                                <table class="table hover-table timetable-datatable"
                                    data-toggle="table"
                                    data-pagination="true"
                                    data-search="true"
                                    data-show-columns="true">
                                    <thead>
                                        <tr>
                                            <th data-field="id"         data-sortable="true">#</th>
                                            <th data-field="name"       data-sortable="true">Exam Name</th>
                                            <th data-field="start"      data-sortable="true">Start Date</th>
                                            <th data-field="end"        data-sortable="true">End Date</th>
                                            <th data-field="schedules"  data-sortable="true">Subjects Scheduled</th>
                                            <th data-field="status"     data-sortable="true">Status</th>
                                            <th data-field="published"  data-sortable="true">Published</th>
                                            <th data-field="actions">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($exams as $i => $exam)
                                        <tr>
                                            <td>{{ $i + 1 }}</td>
                                            <td><strong>{{ $exam->name }}</strong></td>
                                            <td>{{ $exam->start_date ? \Carbon\Carbon::parse($exam->start_date)->format('d M Y') : '—' }}</td>
                                            <td>{{ $exam->end_date ? \Carbon\Carbon::parse($exam->end_date)->format('d M Y') : '—' }}</td>
                                            <td><span class="badge badge-info">{{ $exam->schedules_count }}</span></td>
                                            <td>
                                                @php
                                                    $statusColors = ['upcoming'=>'info','ongoing'=>'warning','completed'=>'success'];
                                                @endphp
                                                <span class="label label-{{ $statusColors[$exam->status] ?? 'default' }}">
                                                    {{ ucfirst($exam->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($exam->is_published)
                                                    <span class="label label-success">Published</span>
                                                @else
                                                    <span class="label label-default">Draft</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div style="display:flex; gap:4px;">
                                                    <a href="{{ route('exams.show', $exam) }}" class="btn btn-xs btn-success" title="View">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('exams.edit', $exam) }}" class="btn btn-xs btn-primary" title="Edit">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('exams.destroy', $exam) }}" method="POST">
                                                        @csrf @method('DELETE')
                                                        <button class="btn btn-xs btn-danger" title="Delete"
                                                            onclick="return confirm('Delete this exam and all its data?')">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="8" class="text-center text-muted" style="padding:40px;">
                                                <i class="fa fa-calendar-o fa-3x" style="color:#ddd;"></i>
                                                <br><br>No exams created yet.
                                                <br><a href="{{ route('exams.create') }}">Create the first exam</a>
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
        <script src="{{ asset('backend/js/data-table/bootstrap-table.js') }}"></script>
        <script src="{{ asset('backend/js/data-table/data-table-active.js') }}"></script>
    @endpush
</x-tenant-app-layout>
