<x-tenant-app-layout>
    @push('css')
        <link rel="stylesheet" href="{{ asset('backend/css/data-table/bootstrap-table.css') }}">
        <style>
            .info-box { background:#fff; border:1px solid #e0e0e0; border-radius:6px; padding:18px 20px; margin-bottom:20px; }
            .info-box h4 { margin:0 0 12px; font-size:15px; font-weight:700; border-bottom:1px solid #f0f0f0; padding-bottom:8px; }
            .info-row { display:flex; justify-content:space-between; padding:6px 0; border-bottom:1px solid #f8f8f8; font-size:13px; }
            .info-row:last-child { border-bottom:none; }
            .info-row span:first-child { color:#888; }
            .info-row span:last-child  { font-weight:600; }
        </style>
    @endpush
    <x-slot name="header"></x-slot>

    <div class="data-table-area mg-b-15">
        <div class="container-fluid">
            <div class="row">

                <x-page-header title="{{ $exam->name ?? 'Exam Detail' }}">
                    <a href="{{ route('exams.schedule.create', $exam) }}" style="color:#333;"><i class="fa fa-plus"></i> Add Schedule</a>
                    <a href="{{ route('exams.results.enter', $exam) }}" style="color:#333;"><i class="fa fa-pencil"></i> Enter Results</a>
                    <a href="{{ route('exams.results.index', $exam) }}" style="color:#333;"><i class="fa fa-bar-chart"></i> View Results</a>
                    <a href="{{ route('exams.edit', $exam) }}" style="color:#333;"><i class="fa fa-edit"></i> Edit Exam</a>
                </x-page-header>

                {{-- Exam Info --}}
                <div class="col-lg-4 col-md-5 col-xs-12">
                    <div class="info-box">
                        <h4><i class="fa fa-calendar"></i> Exam Details</h4>
                        <div class="info-row">
                            <span>Name</span>
                            <span>{{ $exam->name ?? '—' }}</span>
                        </div>
                        <div class="info-row">
                            <span>Start Date</span>
                            <span>{{ $exam->start_date ? \Carbon\Carbon::parse($exam->start_date)->format('d M Y') : '—' }}</span>
                        </div>
                        <div class="info-row">
                            <span>End Date</span>
                            <span>{{ $exam->end_date ? \Carbon\Carbon::parse($exam->end_date)->format('d M Y') : '—' }}</span>
                        </div>
                        <div class="info-row">
                            <span>Subjects Scheduled</span>
                            <span><strong>{{ $exam->schedules->count() }}</strong></span>
                        </div>
                        <div class="info-row">
                            <span>Results Entered</span>
                            <span><strong>{{ $resultsCount }}</strong></span>
                        </div>
                        <div class="info-row">
                            <span>Published</span>
                            <span>
                                @if($exam->is_published)
                                    <span class="label label-success">Yes</span>
                                @else
                                    <span class="label label-default">No</span>
                                @endif
                            </span>
                        </div>
                        @if($exam->description)
                        <div style="margin-top:10px; font-size:13px; color:#666;">
                            {{ $exam->description }}
                        </div>
                        @endif
                    </div>

                    <div style="display:flex; gap:8px; margin-bottom:20px;">
                        <a href="{{ route('exams.results.enter', $exam) }}" class="btn btn-primary btn-sm btn-block">
                            <i class="fa fa-pencil"></i> Enter Marks
                        </a>
                        <a href="{{ route('exams.results.index', $exam) }}" class="btn btn-info btn-sm btn-block">
                            <i class="fa fa-bar-chart"></i> Results
                        </a>
                    </div>

                    <form action="{{ route('exams.destroy', $exam) }}" method="POST">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm btn-block"
                            onclick="return confirm('Delete this exam and all its data?')">
                            <i class="fa fa-trash"></i> Delete Exam
                        </button>
                    </form>
                </div>

                {{-- Schedule Table --}}
                <div class="col-lg-8 col-md-7 col-xs-12">
                    <div class="sparkline13-list">
                        <div class="sparkline13-hd">
                            <div class="main-sparkline13-hd" style="display:flex; justify-content:space-between; align-items:center;">
                                <h1>Exam Schedule</h1>
                                <a href="{{ route('exams.schedule.create', $exam) }}" class="btn btn-primary btn-sm">
                                    <i class="fa fa-plus"></i> Add Subject
                                </a>
                            </div>
                        </div>
                        <div class="sparkline13-graph">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Subject</th>
                                            <th>Class</th>
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th>Room</th>
                                            <th>Max Marks</th>
                                            <th>Pass Marks</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($exam->schedules as $i => $s)
                                        <tr>
                                            <td>{{ $i + 1 }}</td>
                                            <td>{{ $s->subject?->name ?? '—' }}</td>
                                            <td>{{ $s->schoolClass?->name ?? '—' }}</td>
                                            <td>{{ \Carbon\Carbon::parse($s->exam_date)->format('d M Y') }}</td>
                                            <td>{{ $s->start_time ? \Carbon\Carbon::parse($s->start_time)->format('h:i A') : '—' }} – {{ $s->end_time ? \Carbon\Carbon::parse($s->end_time)->format('h:i A') : '—' }}</td>
                                            <td>{{ $s->room_number ?? '—' }}</td>
                                            <td>{{ $s->max_marks ?? '—' }}</td>
                                            <td>{{ $s->passing_marks ?? '—' }}</td>
                                            <td>
                                                <div style="display:flex; gap:4px;">
                                                    <a href="{{ route('exams.schedule.edit', [$exam, $s]) }}" class="btn btn-xs btn-primary" title="Edit">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('exams.schedule.destroy', [$exam, $s]) }}" method="POST">
                                                        @csrf @method('DELETE')
                                                        <button class="btn btn-xs btn-danger" title="Remove"
                                                            onclick="return confirm('Remove this schedule entry?')">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="9" class="text-center text-muted" style="padding:30px;">
                                                <i class="fa fa-calendar-o fa-2x" style="color:#ddd;"></i>
                                                <br>No schedule added yet.
                                                <br><a href="{{ route('exams.schedule.create', $exam) }}">Add the first subject</a>
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
