<x-tenant-app-layout>
    <x-slot name="header"></x-slot>

    @php
        $className   = $session->schoolClass->name ?? $session->timeTable->class->name ?? '—';
        $sectionName = $session->section->name ?? $session->timeTable->section->name ?? '—';
    @endphp

    <div class="container-fluid" style="margin-top: 20px;">

        {{-- Header --}}
        <div class="row" style="margin-bottom: 15px;">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <h3 style="margin: 0; line-height: 34px;">
                    <i class="fa fa-clipboard"></i> Attendance Detail
                </h3>
                <small class="text-muted">
                    {{ $className }} - {{ $sectionName }} &middot; {{ \Carbon\Carbon::parse($session->date)->format('d M Y') }}
                </small>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
                <a href="{{ route('teacher.attendance') }}" class="btn btn-default btn-sm">
                    <i class="fa fa-arrow-left"></i> Back
                </a>
            </div>
        </div>

        {{-- Summary cards --}}
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
                    <h2 class="text-primary" style="margin:0;">{{ $stats['percentage'] }}%</h2>
                    <small class="text-muted">Present Rate</small>
                </div>
            </div>
        </div>

        {{-- Roster --}}
        <div class="row">
            <div class="col-lg-12">
                <div class="white-box">
                    <div class="row" style="margin-bottom: 8px;">
                        <div class="col-md-8">
                            <h3 class="box-title" style="margin:0;"><i class="fa fa-users"></i> Student Roster</h3>
                        </div>
                        <div class="col-md-4 text-right">
                            @if($session->status === 'submitted')
                                <span class="label label-success">Submitted</span>
                            @else
                                <span class="label label-warning">Draft</span>
                            @endif
                        </div>
                    </div>

                    @if($students->isEmpty())
                        <p class="text-muted text-center" style="padding: 30px 0;">
                            <i class="fa fa-inbox fa-3x" style="display:block; margin-bottom:12px;"></i>
                            No students found for this class/section.
                        </p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Student</th>
                                        <th>Admission No.</th>
                                        <th>Status</th>
                                        <th>Remarks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($students as $index => $profile)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $profile->student->name ?? '—' }}</td>
                                            <td>{{ $profile->admission_no ?? '—' }}</td>
                                            <td>
                                                @switch($profile->attendance_status)
                                                    @case('present')
                                                        <span class="label label-success">Present</span>
                                                        @break
                                                    @case('absent')
                                                        <span class="label label-danger">Absent</span>
                                                        @break
                                                    @case('late')
                                                        <span class="label label-warning">Late</span>
                                                        @break
                                                    @default
                                                        <span class="label label-default">Not Marked</span>
                                                @endswitch
                                            </td>
                                            <td>{{ $profile->attendance_remarks ?: '—' }}</td>
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
