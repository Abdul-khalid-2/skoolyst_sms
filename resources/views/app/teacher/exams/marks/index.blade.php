<x-tenant-app-layout>
    <x-slot name="header"></x-slot>

    <div class="container-fluid" style="margin-top: 20px;">

        <div class="row" style="margin-bottom: 15px;">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <h3 style="margin: 0; line-height: 34px;">
                    <i class="fa fa-pencil"></i> Enter Marks
                </h3>
                <small class="text-muted">Record exam results for your students</small>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
                <a href="{{ route('dashboard') }}" class="btn btn-default btn-sm">
                    <i class="fa fa-arrow-left"></i> Back
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="white-box">
                    @if($exams->isEmpty())
                        <p class="text-muted text-center" style="padding: 30px 0;">
                            <i class="fa fa-info-circle fa-3x" style="display:block; margin-bottom:12px;"></i>
                            No exams are available for marks entry.
                            <a href="{{ route('teacher.exams.tests.create') }}">Schedule a test first</a>.
                        </p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Exam</th>
                                        <th>Period</th>
                                        <th>Status</th>
                                        <th>Schedules</th>
                                        <th>Results</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($exams as $exam)
                                        <tr>
                                            <td><strong>{{ $exam->name }}</strong></td>
                                            <td>
                                                {{ \Carbon\Carbon::parse($exam->start_date)->format('d M Y') }}
                                                – {{ \Carbon\Carbon::parse($exam->end_date)->format('d M Y') }}
                                            </td>
                                            <td>
                                                @if($exam->status === 'upcoming')
                                                    <span class="label label-info">Upcoming</span>
                                                @elseif($exam->status === 'ongoing')
                                                    <span class="label label-warning">Ongoing</span>
                                                @else
                                                    <span class="label label-success">Completed</span>
                                                @endif
                                            </td>
                                            <td>{{ $exam->schedules_count }}</td>
                                            <td>{{ $exam->results_count }}</td>
                                            <td>
                                                <a href="{{ route('teacher.exams.marks.enter', $exam) }}" class="btn btn-primary btn-xs">
                                                    <i class="fa fa-pencil"></i> Enter Marks
                                                </a>
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
