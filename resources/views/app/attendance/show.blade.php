<x-tenant-app-layout>
    <x-slot name="header"></x-slot>

    @php
        $className = $session->timeTable->class->name ?? $session->schoolClass?->name ?? 'N/A';
        $sectionName = $session->timeTable->section->name ?? $session->section?->name ?? 'N/A';
    @endphp

    <div class="container-fluid" style="margin-top: 20px;">

        <div class="row" style="margin-bottom: 15px;">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <h3 style="margin: 0; line-height: 34px;">
                    <i class="fa fa-calendar-check-o"></i>
                    Attendance — {{ $className }} ({{ $sectionName }})
                </h3>
                <small class="text-muted">{{ \Carbon\Carbon::parse($session->date)->format('d M Y') }}</small>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
                <a href="{{ route('admin.attendance.index') }}" class="btn btn-default btn-sm">
                    <i class="fa fa-arrow-left"></i> Back to Attendance
                </a>
                <a href="{{ route('admin.attendance.edit', $session->id) }}" class="btn btn-warning btn-sm">
                    <i class="fa fa-edit"></i> Edit
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="white-box">
                    <h3 class="box-title"><i class="fa fa-info-circle"></i> Session Information</h3>
                    <table class="table table-condensed" style="margin-bottom:0;">
                        <tbody>
                            <tr>
                                <th style="width:45%; border-top:none;">Date</th>
                                <td style="border-top:none;">{{ \Carbon\Carbon::parse($session->date)->format('d M Y') }}</td>
                            </tr>
                            <tr>
                                <th>Class</th>
                                <td>{{ $className }}</td>
                            </tr>
                            <tr>
                                <th>Section</th>
                                <td>{{ $sectionName }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    @if(($session->status ?? 'draft') === 'submitted')
                                        <span class="label label-success">Submitted</span>
                                    @else
                                        <span class="label label-warning">Draft</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Recorded By</th>
                                <td>{{ $session->recordedBy?->name ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Notes</th>
                                <td>{{ $session->notes ?? '—' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="white-box text-center">
                            <h2 class="text-success" style="margin:0;">{{ $stats['present'] }}</h2>
                            <small class="text-muted">Present</small>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="white-box text-center">
                            <h2 class="text-danger" style="margin:0;">{{ $stats['absent'] }}</h2>
                            <small class="text-muted">Absent</small>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="white-box text-center">
                            <h2 class="text-warning" style="margin:0;">{{ $stats['late'] }}</h2>
                            <small class="text-muted">Late</small>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="white-box text-center">
                            <h2 style="margin:0;" class="{{ $stats['percentage'] < 75 ? 'text-danger' : ($stats['percentage'] < 85 ? 'text-warning' : 'text-success') }}">
                                {{ $stats['percentage'] }}%
                            </h2>
                            <small class="text-muted">Attendance Rate</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" style="margin-top: 15px;">
            <div class="col-lg-12">
                <div class="white-box">
                    <h3 class="box-title"><i class="fa fa-users"></i> Student Attendance</h3>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Photo</th>
                                    <th>Student Name</th>
                                    <th>Admission No.</th>
                                    <th>Status</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($students as $index => $student)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <img src="{{ $student->photo_url }}"
                                                 alt="{{ $student->student?->name }}"
                                                 style="width:40px;height:40px;border-radius:50%;object-fit:cover;"
                                                 onerror="this.src='{{ asset('backend/img/profile/1.jpg') }}'">
                                        </td>
                                        <td>{{ $student->student?->name ?? 'N/A' }}</td>
                                        <td>{{ $student->admission_no }}</td>
                                        <td>
                                            @if($student->attendance_status === 'present')
                                                <span class="label label-success">Present</span>
                                            @elseif($student->attendance_status === 'absent')
                                                <span class="label label-danger">Absent</span>
                                            @elseif($student->attendance_status === 'late')
                                                <span class="label label-warning">Late</span>
                                            @else
                                                <span class="label label-default">Not Marked</span>
                                            @endif
                                        </td>
                                        <td>{{ $student->attendance_remarks ?? '—' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">No students found for this session.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-tenant-app-layout>
