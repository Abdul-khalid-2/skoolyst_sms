<x-tenant-app-layout>
    <x-slot name="header"></x-slot>

    @php
        $profile = $student->studentProfile;
        $className = $profile->class->name ?? '—';
        $sectionName = $profile->section->name ?? '—';
        $currency = 'PKR ';
        $attColor = $attendance['percentage'] < 75 ? 'text-danger' : ($attendance['percentage'] < 85 ? 'text-warning' : 'text-success');
    @endphp

    <div class="container-fluid" style="margin-top: 20px;">

        {{-- Welcome banner --}}
        <div class="row" style="margin-bottom: 15px;">
            <div class="col-lg-12">
                <div class="white-box" style="display:flex; align-items:center; gap:18px; flex-wrap:wrap;">
                    @if($student->profile_pic)
                        <img src="{{ asset('assets/' . $student->profile_pic) }}" class="rounded-circle"
                             width="70" height="70" style="object-fit:cover;" alt="{{ $student->name }}">
                    @else
                        <img src="{{ asset('backend/img/profile/1.jpg') }}" class="rounded-circle"
                             width="70" height="70" style="object-fit:cover;" alt="{{ $student->name }}">
                    @endif
                    <div>
                        <h3 style="margin:0;">Welcome, {{ $student->name }}!</h3>
                        <small class="text-muted">
                            {{ $className }} ({{ $sectionName }})
                            @if($profile && $profile->admission_no) &middot; Admission No: {{ $profile->admission_no }} @endif
                        </small>
                    </div>
                </div>
            </div>
        </div>

        {{-- Stat cards --}}
        <div class="analytics-sparkle-area">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <a href="{{ route('student.attendance') }}" style="text-decoration:none;">
                        <div class="white-box text-center">
                            <h5 class="text-muted" style="margin-top:0;">Attendance</h5>
                            <h2 class="{{ $attColor }}" style="margin:6px 0;">{{ $attendance['percentage'] }}%</h2>
                            <small class="text-muted">{{ $attendance['present'] + $attendance['late'] }}/{{ $attendance['total'] }} days present</small>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <a href="{{ route('student.results') }}" style="text-decoration:none;">
                        <div class="white-box text-center">
                            <h5 class="text-muted" style="margin-top:0;">Latest Result</h5>
                            @if($latestResult)
                                <h2 class="text-primary" style="margin:6px 0;">{{ $latestResult['percentage'] }}%</h2>
                                <small class="text-muted">{{ $latestResult['exam_name'] }} &middot; Grade {{ $latestResult['grade'] }}</small>
                            @else
                                <h2 class="text-muted" style="margin:6px 0;">—</h2>
                                <small class="text-muted">No published results</small>
                            @endif
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <a href="{{ route('student.fees') }}" style="text-decoration:none;">
                        <div class="white-box text-center">
                            <h5 class="text-muted" style="margin-top:0;">Fee Outstanding</h5>
                            <h2 class="{{ $fees['outstanding'] > 0 ? 'text-danger' : 'text-success' }}" style="margin:6px 0;">
                                {{ $currency }}{{ number_format($fees['outstanding'], 0) }}
                            </h2>
                            <small class="text-muted">
                                @if($fees['overdue'] > 0) {{ $fees['overdue'] }} overdue invoice(s) @else All clear @endif
                            </small>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <a href="{{ route('student.books') }}" style="text-decoration:none;">
                        <div class="white-box text-center">
                            <h5 class="text-muted" style="margin-top:0;">Books Issued</h5>
                            <h2 class="text-info" style="margin:6px 0;">{{ $books['active'] }}</h2>
                            <small class="text-muted">
                                @if($books['overdue'] > 0) <span class="text-danger">{{ $books['overdue'] }} overdue</span> @else On loan @endif
                            </small>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            {{-- Attendance breakdown --}}
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="white-box">
                    <h3 class="box-title"><i class="fa fa-calendar-check-o"></i> Attendance Overview</h3>
                    <div class="row text-center">
                        <div class="col-xs-4">
                            <h3 class="text-success" style="margin:6px 0;">{{ $attendance['present'] }}</h3>
                            <small class="text-muted">Present</small>
                        </div>
                        <div class="col-xs-4">
                            <h3 class="text-warning" style="margin:6px 0;">{{ $attendance['late'] }}</h3>
                            <small class="text-muted">Late</small>
                        </div>
                        <div class="col-xs-4">
                            <h3 class="text-danger" style="margin:6px 0;">{{ $attendance['absent'] }}</h3>
                            <small class="text-muted">Absent</small>
                        </div>
                    </div>
                    <div class="progress" style="margin-top:15px; margin-bottom:5px;">
                        <div class="progress-bar progress-bar-success" role="progressbar"
                             style="width: {{ $attendance['percentage'] }}%;">
                            {{ $attendance['percentage'] }}%
                        </div>
                    </div>
                    <small class="text-muted">Based on {{ $attendance['total'] }} marked day(s).</small>
                    <div style="margin-top:12px;">
                        <a href="{{ route('student.attendance') }}" class="btn btn-default btn-sm">
                            <i class="fa fa-eye"></i> View Detailed Attendance
                        </a>
                    </div>
                </div>
            </div>

            {{-- Notices --}}
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="white-box">
                    <h3 class="box-title"><i class="fa fa-bullhorn"></i> Notice Board</h3>
                    @if($notices->isEmpty())
                        <p class="text-muted text-center" style="padding: 25px 0;">
                            <i class="fa fa-inbox fa-2x" style="display:block; margin-bottom:8px;"></i>
                            No notices at the moment.
                        </p>
                    @else
                        <ul class="list-unstyled" style="margin-bottom:0;">
                            @foreach($notices as $notice)
                                <li style="padding:10px 0; border-bottom:1px solid #f0f0f0;">
                                    <strong>{{ $notice->title }}</strong>
                                    <br>
                                    <small class="text-muted">
                                        {{ $notice->start_date ? \Carbon\Carbon::parse($notice->start_date)->format('d M Y') : '' }}
                                    </small>
                                    <p style="margin:4px 0 0; color:#666; font-size:13px;">
                                        {{ \Illuminate\Support\Str::limit(strip_tags($notice->content), 90) }}
                                    </p>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>

        {{-- Quick links --}}
        <div class="row">
            <div class="col-lg-12">
                <div class="white-box">
                    <h3 class="box-title"><i class="fa fa-th-large"></i> Quick Links</h3>
                    <div class="row text-center">
                        <div class="col-md-2 col-xs-4" style="margin-bottom:12px;">
                            <a href="{{ route('student.profile') }}" class="btn btn-default btn-block">
                                <i class="fa fa-id-card fa-2x" style="display:block; margin-bottom:6px;"></i> My Profile
                            </a>
                        </div>
                        <div class="col-md-2 col-xs-4" style="margin-bottom:12px;">
                            <a href="{{ route('student.attendance') }}" class="btn btn-default btn-block">
                                <i class="fa fa-calendar-check-o fa-2x" style="display:block; margin-bottom:6px;"></i> Attendance
                            </a>
                        </div>
                        <div class="col-md-2 col-xs-4" style="margin-bottom:12px;">
                            <a href="{{ route('student.results') }}" class="btn btn-default btn-block">
                                <i class="fa fa-trophy fa-2x" style="display:block; margin-bottom:6px;"></i> Results
                            </a>
                        </div>
                        <div class="col-md-2 col-xs-4" style="margin-bottom:12px;">
                            <a href="{{ route('student.fees') }}" class="btn btn-default btn-block">
                                <i class="fa fa-credit-card fa-2x" style="display:block; margin-bottom:6px;"></i> Fees
                            </a>
                        </div>
                        <div class="col-md-2 col-xs-4" style="margin-bottom:12px;">
                            <a href="{{ route('student.books') }}" class="btn btn-default btn-block">
                                <i class="fa fa-book fa-2x" style="display:block; margin-bottom:6px;"></i> Books
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-tenant-app-layout>
