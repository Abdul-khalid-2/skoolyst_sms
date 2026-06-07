<x-tenant-app-layout>
    <x-slot name="header"></x-slot>

    <div class="container-fluid" style="margin-top: 20px;">

        <div class="row" style="margin-bottom: 15px;">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <h3 style="margin: 0; line-height: 34px;">
                    <i class="fa fa-pencil-square-o"></i> Create Tests
                </h3>
                <small class="text-muted">Schedule class tests for the subjects you teach</small>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
                <a href="{{ route('teacher.exams.tests.create') }}" class="btn btn-primary btn-sm" style="margin-right: 6px;">
                    <i class="fa fa-plus"></i> Schedule Test
                </a>
                <a href="{{ route('dashboard') }}" class="btn btn-default btn-sm">
                    <i class="fa fa-arrow-left"></i> Back
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="white-box text-center">
                    <h2 class="text-info" style="margin:0;">{{ $stats['total'] }}</h2>
                    <small class="text-muted">Total Tests</small>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="white-box text-center">
                    <h2 class="text-warning" style="margin:0;">{{ $stats['upcoming'] }}</h2>
                    <small class="text-muted">Upcoming</small>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="white-box text-center">
                    <h2 class="text-success" style="margin:0;">{{ $stats['completed'] }}</h2>
                    <small class="text-muted">Completed</small>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="white-box">
                    <h3 class="box-title" style="margin:0 0 12px;"><i class="fa fa-list"></i> My Scheduled Tests</h3>

                    @if($schedules->isEmpty())
                        <p class="text-muted text-center" style="padding: 30px 0;">
                            <i class="fa fa-info-circle fa-2x" style="display:block; margin-bottom:10px;"></i>
                            No tests scheduled yet.
                            <a href="{{ route('teacher.exams.tests.create') }}">Schedule your first test</a>.
                        </p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Exam</th>
                                        <th>Class</th>
                                        <th>Subject</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Max Marks</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($schedules as $schedule)
                                        <tr>
                                            <td>{{ $schedule->exam?->name ?? '—' }}</td>
                                            <td>{{ $schedule->schoolClass?->name ?? '—' }}</td>
                                            <td>{{ $schedule->subject?->name ?? '—' }}</td>
                                            <td>{{ $schedule->exam_date ? \Carbon\Carbon::parse($schedule->exam_date)->format('d M Y') : '—' }}</td>
                                            <td>
                                                @if($schedule->start_time)
                                                    {{ \Carbon\Carbon::parse($schedule->start_time)->format('h:i A') }}
                                                    @if($schedule->end_time)
                                                        – {{ \Carbon\Carbon::parse($schedule->end_time)->format('h:i A') }}
                                                    @endif
                                                @else
                                                    —
                                                @endif
                                            </td>
                                            <td>{{ $schedule->max_marks ?? 100 }}</td>
                                            <td>
                                                @if($schedule->exam)
                                                    <a href="{{ route('teacher.exams.tests.show', $schedule->exam) }}" class="btn btn-default btn-xs">
                                                        <i class="fa fa-eye"></i> View
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>
</x-tenant-app-layout>
