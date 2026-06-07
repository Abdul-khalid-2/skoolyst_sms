<x-tenant-app-layout>
    <x-slot name="header"></x-slot>

    @php
        $profile = $student->studentProfile;
        $className = $profile->class->name ?? '—';
        $sectionName = $profile->section->name ?? '—';
    @endphp

    <div class="container-fluid" style="margin-top: 20px;">

        <div class="row" style="margin-bottom: 15px;">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <h3 style="margin: 0; line-height: 34px;">
                    <i class="fa fa-calendar-check-o"></i> Attendance — {{ $student->name }}
                </h3>
                <small class="text-muted">{{ $className }} ({{ $sectionName }})</small>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
                <a href="{{ route('parent.children') }}" class="btn btn-default btn-sm">
                    <i class="fa fa-arrow-left"></i> Back
                </a>
            </div>
        </div>

        @if($children->count() > 1)
        <div class="row" style="margin-bottom: 10px;">
            <div class="col-lg-12">
                <div class="white-box" style="padding: 12px 20px;">
                    <label style="margin-right:8px;">Switch child:</label>
                    <select class="form-control input-sm" style="max-width:280px; display:inline-block;"
                            onchange="if(this.value) window.location=this.value;">
                        @foreach($children as $child)
                            <option value="{{ route('parent.children.attendance', $child->id) }}"
                                {{ $child->id === $student->id ? 'selected' : '' }}>
                                {{ $child->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        @endif

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

        <div class="row" style="margin-bottom: 10px;">
            <div class="col-lg-12">
                <div class="white-box" style="padding: 12px 20px;">
                    <div class="row" style="display:flex; align-items:center; flex-wrap:wrap;">
                        <div class="col-lg-6">
                            <h4 style="margin:0;"><i class="fa fa-calendar"></i> {{ $selectedMonth->format('F Y') }}</h4>
                            <small class="text-muted">
                                Present: <strong class="text-success">{{ $monthStats['present'] }}</strong> |
                                Absent: <strong class="text-danger">{{ $monthStats['absent'] }}</strong> |
                                Late: <strong class="text-warning">{{ $monthStats['late'] }}</strong> |
                                Rate: <strong>{{ $monthStats['percentage'] }}%</strong>
                            </small>
                        </div>
                        <div class="col-lg-6 text-right">
                            <a href="{{ route('parent.children.attendance', ['student' => $student->id, 'month' => $prevMonth]) }}" class="btn btn-default btn-sm">
                                <i class="fa fa-chevron-left"></i> Prev
                            </a>
                            <a href="{{ route('parent.children.attendance', $student->id) }}" class="btn btn-default btn-sm">This Month</a>
                            <a href="{{ route('parent.children.attendance', ['student' => $student->id, 'month' => $nextMonth]) }}" class="btn btn-default btn-sm">
                                Next <i class="fa fa-chevron-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="white-box">
                    <h3 class="box-title"><i class="fa fa-list"></i> Monthly Records</h3>
                    @if($monthlyRecords->isEmpty())
                        <p class="text-muted text-center" style="padding: 30px 0;">No attendance records for this month.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Class</th>
                                        <th>Section</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($monthlyRecords as $record)
                                        <tr>
                                            <td>{{ $record->session->date ? \Carbon\Carbon::parse($record->session->date)->format('d M Y') : '—' }}</td>
                                            <td>{{ $record->session->schoolClass->name ?? ($record->session->timeTable->class->name ?? '—') }}</td>
                                            <td>{{ $record->session->section->name ?? ($record->session->timeTable->section->name ?? '—') }}</td>
                                            <td>
                                                @switch($record->status)
                                                    @case('present') <span class="label label-success">Present</span> @break
                                                    @case('absent') <span class="label label-danger">Absent</span> @break
                                                    @case('late') <span class="label label-warning">Late</span> @break
                                                    @default <span class="label label-default">{{ ucfirst($record->status) }}</span>
                                                @endswitch
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
