<x-tenant-app-layout>
    <x-slot name="header"></x-slot>

    <div class="container-fluid" style="margin-top: 20px;">

        <div class="row" style="margin-bottom: 15px;">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <h3 style="margin: 0; line-height: 34px;">
                    <i class="fa fa-calendar"></i> {{ $exam->name }}
                </h3>
                <small class="text-muted">
                    {{ \Carbon\Carbon::parse($exam->start_date)->format('d M Y') }}
                    – {{ \Carbon\Carbon::parse($exam->end_date)->format('d M Y') }}
                </small>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
                <a href="{{ route('teacher.exams.marks.enter', $exam) }}" class="btn btn-primary btn-sm" style="margin-right: 6px;">
                    <i class="fa fa-pencil"></i> Enter Marks
                </a>
                <a href="{{ route('teacher.exams.tests.index') }}" class="btn btn-default btn-sm">
                    <i class="fa fa-arrow-left"></i> Back
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4 col-md-5 col-xs-12">
                <div class="white-box">
                    <h4 style="margin:0 0 12px; font-size:15px; font-weight:700;">Exam Summary</h4>
                    <table class="table table-condensed" style="margin:0;">
                        <tr>
                            <td class="text-muted">Status</td>
                            <td>
                                @if($exam->status === 'upcoming')
                                    <span class="label label-info">Upcoming</span>
                                @elseif($exam->status === 'ongoing')
                                    <span class="label label-warning">Ongoing</span>
                                @else
                                    <span class="label label-success">Completed</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted">My Tests</td>
                            <td><strong>{{ $exam->schedules->count() }}</strong></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Results Entered</td>
                            <td><strong>{{ $resultsCount }}</strong></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Published</td>
                            <td>
                                @if($exam->is_published)
                                    <span class="label label-success">Yes</span>
                                @else
                                    <span class="label label-default">No</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                    @if($exam->description)
                        <p class="text-muted" style="margin-top:12px; font-size:13px;">{{ $exam->description }}</p>
                    @endif
                </div>
            </div>

            <div class="col-lg-8 col-md-7 col-xs-12">
                <div class="white-box">
                    <h4 style="margin:0 0 12px; font-size:15px; font-weight:700;">
                        <i class="fa fa-list"></i> My Test Schedule
                    </h4>

                    @if($exam->schedules->isEmpty())
                        <p class="text-muted text-center" style="padding: 20px 0;">No tests scheduled for your subjects yet.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Class</th>
                                        <th>Subject</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Room</th>
                                        <th>Marks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($exam->schedules as $schedule)
                                        <tr>
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
                                            <td>{{ $schedule->room_number ?? '—' }}</td>
                                            <td>{{ $schedule->max_marks ?? 100 }} / {{ $schedule->passing_marks ?? 40 }}</td>
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
