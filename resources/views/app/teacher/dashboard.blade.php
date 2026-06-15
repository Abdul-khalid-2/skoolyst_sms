<x-tenant-app-layout>
    <x-slot name="header"></x-slot>

    @push('css')
        <style>
            .next-class-card {
                background: linear-gradient(135deg, #1e3a5f 0%, #2563eb 100%);
                border-radius: 12px;
                color: #fff;
                padding: 24px;
                margin-bottom: 20px;
                box-shadow: 0 8px 24px rgba(37, 99, 235, 0.25);
            }
            .next-class-card.in-progress {
                background: linear-gradient(135deg, #065f46 0%, #10b981 100%);
                box-shadow: 0 8px 24px rgba(16, 185, 129, 0.25);
            }
            .next-class-card .nc-label {
                font-size: 11px;
                text-transform: uppercase;
                letter-spacing: 0.06em;
                opacity: 0.85;
                margin-bottom: 4px;
            }
            .next-class-card .nc-value {
                font-size: 15px;
                font-weight: 600;
                margin-bottom: 14px;
            }
            .next-class-card .nc-timer-wrap {
                text-align: center;
                padding: 16px;
                background: rgba(255,255,255,0.12);
                border-radius: 10px;
                min-height: 120px;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
            }
            .next-class-card .nc-countdown {
                font-size: 36px;
                font-weight: 700;
                letter-spacing: 0.04em;
                line-height: 1.2;
                font-variant-numeric: tabular-nums;
            }
            .next-class-card .nc-datetime {
                font-size: 22px;
                font-weight: 700;
                line-height: 1.4;
            }
            .next-class-card .nc-sub {
                font-size: 13px;
                opacity: 0.9;
                margin-top: 6px;
            }
            .next-class-card .nc-badge {
                display: inline-block;
                background: rgba(255,255,255,0.2);
                border-radius: 20px;
                padding: 4px 12px;
                font-size: 12px;
                font-weight: 600;
                margin-bottom: 12px;
            }
            .next-class-card .nc-detail-grid {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 0 16px;
            }
            @media (max-width: 767px) {
                .next-class-card .nc-detail-grid { grid-template-columns: 1fr; }
                .next-class-card .nc-countdown { font-size: 28px; }
            }
        </style>
    @endpush

    <div class="container-fluid" style="margin-top:20px;">
        <h3 style="margin-bottom:15px;"><i class="fa fa-tachometer"></i> Teacher Dashboard</h3>

        @if($upcomingClass)
            <div class="row">
                <div class="col-lg-12">
                    <div class="next-class-card {{ $upcomingClass['status'] === 'in_progress' ? 'in-progress' : '' }}" id="nextClassCard">
                        <div class="row">
                            <div class="col-md-7 col-sm-12">
                                @if($upcomingClass['status'] === 'in_progress')
                                    <span class="nc-badge"><i class="fa fa-circle" style="font-size:8px; vertical-align:middle;"></i> Class In Progress</span>
                                @else
                                    <span class="nc-badge"><i class="fa fa-clock-o"></i> Next Class</span>
                                @endif

                                <div class="nc-detail-grid">
                                    <div>
                                        <div class="nc-label">Class</div>
                                        <div class="nc-value">{{ $upcomingClass['class_name'] }}</div>
                                    </div>
                                    <div>
                                        <div class="nc-label">Section</div>
                                        <div class="nc-value">{{ $upcomingClass['section_name'] }}</div>
                                    </div>
                                    <div>
                                        <div class="nc-label">Subject</div>
                                        <div class="nc-value">{{ $upcomingClass['subject_name'] }}</div>
                                    </div>
                                    <div>
                                        <div class="nc-label">Period</div>
                                        <div class="nc-value">{{ $upcomingClass['period_name'] }}</div>
                                    </div>
                                    <div>
                                        <div class="nc-label">Room</div>
                                        <div class="nc-value">{{ $upcomingClass['room'] }}</div>
                                    </div>
                                    <div>
                                        <div class="nc-label">Class Time</div>
                                        <div class="nc-value">{{ $upcomingClass['start_formatted'] }} – {{ $upcomingClass['end_formatted'] }}</div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-5 col-sm-12" style="margin-top:12px;">
                                <div class="nc-timer-wrap">
                                    @if($upcomingClass['display_mode'] === 'countdown')
                                        <div class="nc-label" id="ncTimerLabel">
                                            @if($upcomingClass['status'] === 'in_progress')
                                                Time Remaining
                                            @else
                                                Starts In
                                            @endif
                                        </div>
                                        <div class="nc-countdown" id="ncCountdown">--:--:--</div>
                                        <div class="nc-sub" id="ncCountdownSub">{{ $upcomingClass['date_formatted'] }}</div>
                                    @else
                                        <div class="nc-label">Scheduled For</div>
                                        <div class="nc-datetime">{{ $upcomingClass['datetime_formatted'] }}</div>
                                        <div class="nc-sub">Countdown appears when class is within 23 hours</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="row">
                <div class="col-lg-12">
                    <div class="white-box" style="margin-bottom:20px; border-left:4px solid #94a3b8;">
                        <p style="margin:0; color:#64748b;">
                            <i class="fa fa-calendar-o"></i>
                            No upcoming class found on your timetable.
                            @if(Route::has('teacher.timetable'))
                                <a href="{{ route('teacher.timetable') }}">View timetable</a>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <div class="row">
            <div class="col-lg-3 col-md-6"><div class="white-box text-center"><h2 class="text-info" style="margin:0;">{{ $studentCount }}</h2><small>My Students</small></div></div>
            <div class="col-lg-3 col-md-6"><div class="white-box text-center"><h2 class="text-primary" style="margin:0;">{{ $sectionCount }}</h2><small>Sections</small></div></div>
            <div class="col-lg-3 col-md-6"><div class="white-box text-center"><h2 class="text-success" style="margin:0;">{{ $subjectCount }}</h2><small>Subjects</small></div></div>
            <div class="col-lg-3 col-md-6"><div class="white-box text-center"><h2 class="text-warning" style="margin:0;">{{ $resultsEntered }}</h2><small>Results Entered</small></div></div>
        </div>

        <div class="row" style="margin-top:15px;">
            <div class="col-lg-12">
                <div class="white-box">
                    <h4>Quick Links</h4>
                    <a href="{{ route('teacher.attendance') }}" class="btn btn-primary btn-sm">Mark Attendance</a>
                    <a href="{{ route('teacher.exams.marks.index') }}" class="btn btn-success btn-sm">Enter Marks</a>
                    <a href="{{ route('teacher.students') }}" class="btn btn-default btn-sm">My Students</a>
                    @if(Route::has('teacher.timetable'))
                        <a href="{{ route('teacher.timetable') }}" class="btn btn-default btn-sm">My Timetable</a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if($upcomingClass && $upcomingClass['display_mode'] === 'countdown')
        @push('js')
            <script>
                (function() {
                    var targetIso = @json($upcomingClass['countdown_target'] === 'end' ? $upcomingClass['end_at'] : $upcomingClass['start_at']);
                    var countdownEl = document.getElementById('ncCountdown');
                    var cardEl = document.getElementById('nextClassCard');

                    if (!countdownEl || !targetIso) return;

                    function pad(n) { return String(n).padStart(2, '0'); }

                    function formatRemaining(totalSeconds) {
                        var h = Math.floor(totalSeconds / 3600);
                        var m = Math.floor((totalSeconds % 3600) / 60);
                        var s = totalSeconds % 60;
                        return pad(h) + ':' + pad(m) + ':' + pad(s);
                    }

                    function tick() {
                        var target = new Date(targetIso).getTime();
                        var now = Date.now();
                        var diff = Math.max(0, Math.floor((target - now) / 1000));

                        countdownEl.textContent = formatRemaining(diff);

                        if (diff <= 0) {
                            clearInterval(timer);
                            if (cardEl) {
                                window.location.reload();
                            }
                        }
                    }

                    tick();
                    var timer = setInterval(tick, 1000);
                })();
            </script>
        @endpush
    @endif
</x-tenant-app-layout>
