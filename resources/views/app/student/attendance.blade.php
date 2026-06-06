<x-tenant-app-layout>
    <x-slot name="header"></x-slot>

    @php
        $profile = $student->studentProfile;
        $className = $profile->class->name ?? '—';
        $sectionName = $profile->section->name ?? '—';
    @endphp

    <div class="container-fluid" style="margin-top: 20px;">

        {{-- Header --}}
        <div class="row" style="margin-bottom: 15px;">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <h3 style="margin: 0; line-height: 34px;">
                    <i class="fa fa-calendar-check-o"></i> My Attendance
                </h3>
                <small class="text-muted">{{ $className }} ({{ $sectionName }})</small>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
                <a href="{{ route('dashboard') }}" class="btn btn-default btn-sm">
                    <i class="fa fa-arrow-left"></i> Back
                </a>
            </div>
        </div>

        {{-- Overall summary cards --}}
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="white-box text-center">
                    <h2 class="text-info" style="margin:0;">{{ $overallStats['total'] }}</h2>
                    <small class="text-muted">Total Days Marked</small>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="white-box text-center">
                    <h2 class="text-success" style="margin:0;">{{ $overallStats['present'] }}</h2>
                    <small class="text-muted">Present</small>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="white-box text-center">
                    <h2 class="text-danger" style="margin:0;">{{ $overallStats['absent'] }}</h2>
                    <small class="text-muted">Absent</small>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="white-box text-center">
                    <h2 style="margin:0;" class="{{ $overallStats['percentage'] < 75 ? 'text-danger' : ($overallStats['percentage'] < 85 ? 'text-warning' : 'text-success') }}">
                        {{ $overallStats['percentage'] }}%
                    </h2>
                    <small class="text-muted">Overall Attendance</small>
                </div>
            </div>
        </div>

        {{-- Month navigation --}}
        <div class="row" style="margin-bottom: 10px;">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="white-box" style="padding: 12px 20px;">
                    <div class="row" style="display:flex; align-items:center; flex-wrap:wrap;">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <h4 style="margin:0;">
                                <i class="fa fa-calendar"></i> {{ $selectedMonth->format('F Y') }}
                            </h4>
                            <small class="text-muted">
                                Present: <strong class="text-success">{{ $monthStats['present'] }}</strong> &nbsp;|&nbsp;
                                Absent: <strong class="text-danger">{{ $monthStats['absent'] }}</strong> &nbsp;|&nbsp;
                                Late: <strong class="text-warning">{{ $monthStats['late'] }}</strong> &nbsp;|&nbsp;
                                Rate: <strong>{{ $monthStats['percentage'] }}%</strong>
                            </small>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-right">
                            <a href="{{ route('student.attendance', ['month' => $prevMonth]) }}" class="btn btn-default btn-sm">
                                <i class="fa fa-chevron-left"></i> Prev
                            </a>
                            <a href="{{ route('student.attendance') }}" class="btn btn-default btn-sm">
                                This Month
                            </a>
                            <a href="{{ route('student.attendance', ['month' => $nextMonth]) }}" class="btn btn-default btn-sm">
                                Next <i class="fa fa-chevron-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            {{-- Calendar --}}
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="white-box">
                    <h3 class="box-title"><i class="fa fa-calendar"></i> Calendar View</h3>
                    <div id="attendanceCalendar"></div>
                </div>
            </div>

            {{-- Records table --}}
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="white-box">
                    <h3 class="box-title"><i class="fa fa-list"></i> Daily Records</h3>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Day</th>
                                    <th>Status</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($monthlyRecords as $record)
                                    @php $date = \Carbon\Carbon::parse($record->session->date); @endphp
                                    <tr>
                                        <td>{{ $date->format('d M Y') }}</td>
                                        <td>{{ $date->format('D') }}</td>
                                        <td>
                                            @if($record->status === 'present')
                                                <span class="label label-success">Present</span>
                                            @elseif($record->status === 'absent')
                                                <span class="label label-danger">Absent</span>
                                            @elseif($record->status === 'late')
                                                <span class="label label-warning">Late</span>
                                            @else
                                                <span class="label label-default">{{ ucfirst($record->status ?? 'N/A') }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $record->remarks ?? '—' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted" style="padding: 20px 0;">
                                            <i class="fa fa-inbox fa-2x" style="display:block; margin-bottom:8px;"></i>
                                            No attendance records for {{ $selectedMonth->format('F Y') }}.
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

    @push('js')
    <script>
        $(document).ready(function () {
            if ($('#attendanceCalendar').length && $.fn.fullCalendar) {
                $('#attendanceCalendar').fullCalendar({
                    defaultDate: '{{ $selectedMonth->format('Y-m-d') }}',
                    header: {
                        left: 'title',
                        center: '',
                        right: 'prev,next'
                    },
                    height: 'auto',
                    events: @json($calendarEvents),
                });
            }
        });
    </script>
    @endpush
</x-tenant-app-layout>
