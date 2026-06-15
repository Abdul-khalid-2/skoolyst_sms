<x-tenant-app-layout>
    @push('css')

        <link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico">
        <!-- Google Fonts
            ============================================ -->
        <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,700,900" rel="stylesheet">
        <!-- Bootstrap CSS
            ============================================ -->
        <link rel="stylesheet" href="{{ asset('backend/css/bootstrap.min.css') }}">
        <!-- Bootstrap CSS
            ============================================ -->
        <link rel="stylesheet" href="{{ asset('backend/css/font-awesome.min.css') }}">
        <!-- owl.carousel CSS
            ============================================ -->
        <link rel="stylesheet" href="{{ asset('backend/css/owl.carousel.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/owl.theme.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/owl.transitions.css') }}">
        <!-- animate CSS
            ============================================ -->
        <link rel="stylesheet" href="{{ asset('backend/css/animate.css') }}">
        <!-- normalize CSS
            ============================================ -->
        <link rel="stylesheet" href="{{ asset('backend/css/normalize.css') }}">
        <!-- meanmenu icon CSS
            ============================================ -->
        <link rel="stylesheet" href="{{ asset('backend/css/meanmenu.min.css') }}">
        <!-- main CSS
            ============================================ -->
        <link rel="stylesheet" href="{{ asset('backend/css/main.css') }}">
        <!-- educate icon CSS
            ============================================ -->
        <link rel="stylesheet" href="{{ asset('backend/css/educate-custon-icon.css') }}">
        <!-- morrisjs CSS
            ============================================ -->
        <link rel="stylesheet" href="{{ asset('backend/css/morrisjs/morris.css') }}">
        <!-- mCustomScrollbar CSS
            ============================================ -->
        <link rel="stylesheet" href="{{ asset('backend/css/scrollbar/jquery.mCustomScrollbar.min.css') }}">
        <!-- metisMenu CSS
            ============================================ -->
        <link rel="stylesheet" href="{{ asset('backend/css/metisMenu/metisMenu.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/metisMenu/metisMenu-vertical.css') }}">
        <!-- calendar CSS
            ============================================ -->
        <link rel="stylesheet" href="{{ asset('backend/css/calendar/fullcalendar.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/calendar/fullcalendar.print.min.css') }}">
        <!-- touchspin CSS
            ============================================ -->
        <link rel="stylesheet" href="{{ asset('backend/css/touchspin/jquery.bootstrap-touchspin.min.css') }}">
        <!-- datapicker CSS
            ============================================ -->
        <link rel="stylesheet" href="{{ asset('backend/css/datapicker/datepicker3.css') }}">
        <!-- forms CSS
            ============================================ -->
        <link rel="stylesheet" href="{{ asset('backend/css/form/themesaller-forms.css') }}">
        <!-- colorpicker CSS
            ============================================ -->
        <link rel="stylesheet" href="{{ asset('backend/css/colorpicker/colorpicker.css') }}">
        <!-- select2 CSS
            ============================================ -->
        <link rel="stylesheet" href="{{ asset('backend/css/select2/select2.min.css') }}">
        <!-- chosen CSS
            ============================================ -->
        <link rel="stylesheet" href="{{ asset('backend/css/chosen/bootstrap-chosen.css') }}">
        <!-- ionRangeSlider CSS
            ============================================ -->
        <link rel="stylesheet" href="{{ asset('backend/css/ionRangeSlider/ion.rangeSlider.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/ionRangeSlider/ion.rangeSlider.skinFlat.css') }}">
        <!-- style CSS
            ============================================ -->
        
        <!-- responsive CSS
            ============================================ -->
        <link rel="stylesheet" href="{{ asset('backend/css/responsive.css') }}">
        <!-- modernizr JS
            ============================================ -->
        <script src="{{ asset('backend/js/vendor/modernizr-2.8.3.min.js') }}"></script>

        <style>
            .profile-info td {
                padding: 8px 0;
                border-bottom: 1px solid #f1f1f1;
            }
            .profile-info td:first-child {
                font-weight: 600;
                width: 30%;
            }
            .logo-container {
                width: 150px;
                height: 150px;
                border-radius: 50%;
                overflow: hidden;
                border: 3px solid #fff;
                box-shadow: 0 0 10px rgba(0,0,0,0.1);
            }
            .stat-card {
                border-radius: 5px;
                padding: 20px;
                margin-bottom: 20px;
                color: #fff;
            }
            .stat-card i {
                font-size: 30px;
                margin-bottom: 10px;
            }
            .edit-btn {
                position: absolute;
                right: 20px;
                top: 20px;
            }

            /* Section Teachers tab */
            .st-wrap { margin-top: 14px; }
            .st-toolbar {
                display: flex;
                flex-wrap: wrap;
                align-items: center;
                justify-content: space-between;
                gap: 10px;
                margin-bottom: 14px;
            }
            .st-search {
                position: relative;
                flex: 1;
                min-width: 220px;
                max-width: 360px;
            }
            .st-search input {
                width: 100%;
                padding: 9px 12px 9px 34px;
                border: 1px solid #dde3ea;
                border-radius: 8px;
                font-size: 13px;
            }
            .st-search i {
                position: absolute;
                left: 11px;
                top: 50%;
                transform: translateY(-50%);
                color: #94a3b8;
            }
            .st-layout {
                display: flex;
                gap: 16px;
                align-items: flex-start;
            }
            .st-sidebar {
                width: 280px;
                flex-shrink: 0;
                background: #f8fafc;
                border: 1px solid #e2e8f0;
                border-radius: 10px;
                max-height: 520px;
                overflow-y: auto;
            }
            .st-class-group { border-bottom: 1px solid #e8edf3; }
            .st-class-group:last-child { border-bottom: none; }
            .st-class-head {
                padding: 10px 14px 6px;
                font-size: 12px;
                font-weight: 700;
                color: #64748b;
                text-transform: uppercase;
                letter-spacing: .04em;
            }
            .st-section-list { padding: 0 10px 10px; display: flex; flex-wrap: wrap; gap: 6px; }
            .st-section-btn {
                border: 1px solid #cbd5e1;
                background: #fff;
                color: #334155;
                border-radius: 999px;
                padding: 5px 12px;
                font-size: 12px;
                cursor: pointer;
                transition: all .15s ease;
            }
            .st-section-btn:hover { border-color: #6366f1; color: #4338ca; }
            .st-section-btn.active {
                background: #6366f1;
                border-color: #6366f1;
                color: #fff;
            }
            .st-section-btn .st-badge {
                display: inline-block;
                margin-left: 4px;
                background: rgba(0,0,0,.08);
                border-radius: 10px;
                padding: 0 6px;
                font-size: 10px;
            }
            .st-section-btn.active .st-badge { background: rgba(255,255,255,.25); }
            .st-main {
                flex: 1;
                min-width: 0;
                background: #fff;
                border: 1px solid #e2e8f0;
                border-radius: 10px;
                overflow: hidden;
            }
            .st-main-head {
                padding: 16px 18px;
                border-bottom: 1px solid #eef2f7;
                background: linear-gradient(135deg, #f8fafc 0%, #eef2ff 100%);
            }
            .st-main-head h4 { margin: 0 0 4px; font-size: 18px; color: #1e293b; }
            .st-main-head p { margin: 0; font-size: 12px; color: #64748b; }
            .st-subject-grid {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
                gap: 10px;
                padding: 14px;
            }
            .st-subject-card {
                border: 1px solid #e8edf3;
                border-radius: 8px;
                padding: 12px 14px;
                background: #fff;
            }
            .st-subject-card .st-subject-name {
                font-weight: 600;
                color: #1e293b;
                font-size: 14px;
                margin-bottom: 6px;
            }
            .st-subject-card .st-subject-code {
                display: inline-block;
                font-size: 10px;
                background: #eef2ff;
                color: #4338ca;
                padding: 2px 6px;
                border-radius: 4px;
                margin-left: 4px;
                vertical-align: middle;
            }
            .st-subject-card .st-teacher {
                font-size: 13px;
                color: #475569;
            }
            .st-subject-card .st-teacher i { color: #6366f1; margin-right: 4px; }
            .st-empty {
                padding: 40px 20px;
                text-align: center;
                color: #94a3b8;
            }
            .st-empty i { font-size: 28px; display: block; margin-bottom: 8px; }
            @media (max-width: 991px) {
                .st-layout { flex-direction: column; }
                .st-sidebar { width: 100%; max-height: none; }
            }
        </style>

    @endpush

    <x-slot name="header"></x-slot>

    <div class="container-fluid">
        <div class="row">
            <x-page-header title="School Profile">
                <a href="{{ route('schools.show') }}" style="color: #333;"><i class="fa fa-building"></i> Profile</a>
                <a href="{{ route('schools.cms') }}" style="color: #333;"><i class="fa fa-paint-brush"></i> CMS</a>
                <a href="{{ route('schools.edit') }}" style="color: #333;"><i class="fa fa-edit"></i> Edit Profile</a>
                <a href="{{ route('schools.settings') }}" style="color: #333;"><i class="fa fa-cog"></i> Settings</a>
            </x-page-header>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="sparkline12-list">
  
                            
                    <div class="row">
                        
                        <div class="col-12">
                            <div class="profile-tabs">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#basic" data-toggle="tab">Basic Information</a></li>
                                    <li><a href="#contact" data-toggle="tab">Contact Details</a></li>
                                    <li><a href="#classes-sections" data-toggle="tab"><i class="fa fa-graduation-cap"></i> Classes &amp; Sections</a></li>
                                    <li><a href="#subjects-offered" data-toggle="tab"><i class="fa fa-book"></i> Subjects</a></li>
                                    <li><a href="#teachers-overview" data-toggle="tab"><i class="fa fa-users"></i> Teachers</a></li>
                                    <li><a href="#section-teachers" data-toggle="tab"><i class="fa fa-user-plus"></i> Section Teachers</a></li>
                                </ul>
                                
                                <div class="tab-content">
                                    <div class="tab-pane active" id="basic">
                                        <div class="table-responsive" style="margin-top: 15px;">
                                            <table class="table table-striped table-bordered">
                                                
                                                <tbody>
                                                    <tr>                                                        
                                                        <td colspan="2" >
                                                            @if(isset($school->logo) && $school->logo)
                                                                <img src="{{ asset('assets/' . $school->logo) }}" alt="School Logo"
                                                                     style="width:80px; height:80px; object-fit:cover; border:2px solid #ddd;">
                                                            @else
                                                                <img src="{{ asset('backend/img/profile/1.jpg') }}" alt="School Logo"
                                                                     style="width:80px; height:80px; object-fit:cover; border:2px solid #ddd;">
                                                            @endif
                                                        </td>
                                                        <!-- <td><strong></strong></td> -->
                                                    </tr>
                                                    <tr><td><strong>School Name</strong></td><td>{{ $school->name ?? '—' }}</td></tr>
                                                    <tr><td><strong>Academic Session</strong></td><td>{{ $school->session_year ?? '—' }}</td></tr>
                                                    <tr><td><strong>Established</strong></td><td>{{ $school->established_year ?? 'Not specified' }}</td></tr>
                                                    <tr><td><strong>School Type</strong></td><td>{{ $school->type ?? 'Not specified' }}</td></tr>
                                                    <tr><td><strong>Affiliation</strong></td><td>{{ $school->affiliation ?? 'Not specified' }}</td></tr>
                                                    <tr><td><strong>Principal</strong></td><td>{{ $school->principal ?? 'Not specified' }}</td></tr>
                                                    <tr><td><strong>About School</strong></td><td>{{ $school->about ?? 'Not specified' }}</td></tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    
                                    <div class="tab-pane" id="contact">
                                        <div class="table-responsive" style="margin-top: 15px;">
                                            <table class="table table-striped table-bordered">
                                                <thead style="background:#f5f5f5;">
                                                    <tr>
                                                        <th style="width:35%;">Field</th>
                                                        <th>Value</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr><td><strong>Address</strong></td><td>{{ $school->address ?? '—' }}</td></tr>
                                                    <tr><td><strong>Phone Number</strong></td><td>{{ $school->phone ?? '—' }}</td></tr>
                                                    <tr><td><strong>Email Address</strong></td><td>{{ $school->email ?? '—' }}</td></tr>
                                                    <tr><td><strong>Website</strong></td><td>{{ $school->website ?? 'Not specified' }}</td></tr>
                                                    <tr>
                                                        <td><strong>Social Media</strong></td>
                                                        <td>
                                                            @if(isset($school->social_links) && count($school->social_links ?? []))
                                                                @foreach($school->social_links as $platform => $link)
                                                                    @if($link)
                                                                        <a href="{{ $link }}" target="_blank" class="btn btn-default btn-xs">
                                                                            <i class="fa fa-{{ $platform }}"></i> {{ ucfirst($platform) }}
                                                                        </a>
                                                                    @endif
                                                                @endforeach
                                                            @else
                                                                Not specified
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr><td><strong>School Hours</strong></td><td>{{ $school->working_hours ?? 'Not specified' }}</td></tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    
                                    <div class="tab-pane" id="classes-sections">
                                        <div class="table-responsive" style="margin-top: 15px;">
                                            <table class="table table-bordered" style="margin-bottom:0;">
                                                <thead style="background:#f5f5f5;">
                                                    <tr>
                                                        <th style="width:18%;">Class</th>
                                                        <th>Sections &amp; Students</th>
                                                        <th style="width:13%; text-align:center;">Total Students</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($classes as $class)
                                                        @php
                                                            $totalStudents = $class->sections->sum(fn($s) => $s->students->count());
                                                        @endphp
                                                        <tr>
                                                            <td style="vertical-align:middle;">
                                                                <strong>{{ $class->name ?? '' }}</strong>
                                                            </td>
                                                            <td style="vertical-align:middle;">
                                                                @forelse($class->sections as $section)
                                                                    @php $count = $section->students->count(); @endphp
                                                                    <span style="display:inline-flex; align-items:center; gap:5px;
                                                                                 background:#eaf2fb; border:1px solid #aed6f1;
                                                                                 border-radius:4px; padding:3px 8px; margin:2px 4px 2px 0;">
                                                                        <span class="label label-primary" style="font-size:11px; padding:2px 6px;">
                                                                            {{ $section->name }}
                                                                        </span>
                                                                        <span style="font-size:12px; color:#555;">
                                                                            <i class="fa fa-users" style="color:#aaa; font-size:10px;"></i>
                                                                            {{ $count }}
                                                                        </span>
                                                                    </span>
                                                                @empty
                                                                    <span class="text-muted">No sections</span>
                                                                @endforelse
                                                            </td>
                                                            <td style="text-align:center; vertical-align:middle;">
                                                                <span class="badge"
                                                                      style="background:{{ $totalStudents > 0 ? '#27ae60' : '#aaa' }};
                                                                             font-size:13px; padding:4px 10px;">
                                                                    {{ $totalStudents }}
                                                                </span>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="3" class="text-muted text-center">No classes found</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                                @if($classes->isNotEmpty())
                                                <tfoot style="background:#f5f5f5; font-weight:600;">
                                                    <tr>
                                                        <td>Grand Total</td>
                                                        <td>
                                                            @php $totalSections = $classes->sum(fn($c) => $c->sections->count()); @endphp
                                                            {{ $totalSections }} {{ Str::plural('section', $totalSections) }}
                                                            across {{ $classes->count() }} {{ Str::plural('class', $classes->count()) }}
                                                        </td>
                                                        <td style="text-align:center;">
                                                            @php $grandTotal = $classes->sum(fn($c) => $c->sections->sum(fn($s) => $s->students->count())); @endphp
                                                            <span class="badge" style="background:#2980b9; font-size:13px; padding:4px 10px;">
                                                                {{ $grandTotal }}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                                @endif
                                            </table>
                                        </div>
                                        <div style="margin-top:12px; text-align:right;">
                                            <a href="{{ route('admin.academic.classes.index') }}" class="btn btn-sm btn-primary">
                                                <i class="fa fa-graduation-cap"></i> Manage Classes
                                            </a>
                                            <a href="{{ route('admin.academic.sections.index') }}" class="btn btn-sm btn-default" style="margin-left:6px;">
                                                <i class="fa fa-sitemap"></i> Manage Sections
                                            </a>
                                            <a href="{{ route('admin.academic.subjects.section_teacher') }}" class="btn btn-sm btn-success" style="margin-left:6px;">
                                                <i class="fa fa-user-plus"></i> Section Teacher Allocation
                                            </a>
                                        </div>
                                    </div>

                                    <div class="tab-pane" id="subjects-offered">
                                        <div class="table-responsive" style="margin-top: 15px;">
                                            <table class="table table-striped table-bordered">
                                                <thead style="background:#f5f5f5;">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Subject</th>
                                                        <th>Code</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($subjects as $i => $subject)
                                                        <tr>
                                                            <td>{{ $i + 1 }}</td>
                                                            <td>{{ $subject->name ?? '' }}</td>
                                                            <td><span class="label label-default">{{ $subject->code ?? '—' }}</span></td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="3" class="text-muted text-center">No subjects found</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                        <div style="margin-top:12px; text-align:right;">
                                            <a href="{{ route('admin.academic.subjects.index') }}" class="btn btn-sm btn-primary">
                                                <i class="fa fa-book"></i> Manage Subjects
                                            </a>
                                        </div>
                                    </div>

                                    {{-- Teachers: Subjects & Classes (merged) --}}
                                    <div class="tab-pane" id="teachers-overview">
                                        <div class="table-responsive" style="margin-top: 15px;">
                                            <table class="table table-striped table-bordered">
                                                <thead style="background:#f5f5f5;">
                                                    <tr>
                                                        <th style="width:5%;">#</th>
                                                        <th style="width:22%;">Teacher</th>
                                                        <th style="width:18%;">Class Teacher Of</th>
                                                        <th>Subjects Assigned</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($teachers as $i => $teacher)
                                                        <tr>
                                                            <td style="vertical-align:middle;">{{ $i + 1 }}</td>
                                                            <td style="vertical-align:middle;"><strong>{{ $teacher->name }}</strong></td>
                                                            <td style="vertical-align:middle;">
                                                                @if($teacher->teacherProfile && $teacher->teacherProfile->classTeacherOf)
                                                                    <span class="label label-success" style="font-size:12px; padding:4px 8px;">
                                                                        <i class="fa fa-graduation-cap"></i>
                                                                        {{ $teacher->teacherProfile->classTeacherOf->name }}
                                                                    </span>
                                                                @else
                                                                    <span class="text-muted" style="font-size:12px;">—</span>
                                                                @endif
                                                            </td>
                                                            <td style="vertical-align:middle;">
                                                                @if($teacher->teacherSubjects->isNotEmpty())
                                                                    @foreach($teacher->teacherSubjects as $subject)
                                                                        <span class="label label-primary" style="margin-right:4px; font-size:11px;">
                                                                            {{ $subject->name }}
                                                                        </span>
                                                                    @endforeach
                                                                @else
                                                                    <span class="text-muted" style="font-size:12px;">No subjects assigned</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="4" class="text-muted text-center">No teachers found</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                        <div style="margin-top:12px; text-align:right;">
                                            <a href="{{ route('dashboard.teachers') }}" class="btn btn-sm btn-primary">
                                                <i class="fa fa-users"></i> Manage Teachers
                                            </a>
                                            <a href="{{ route('admin.academic.subjects.assign') }}" class="btn btn-sm btn-default" style="margin-left:6px;">
                                                <i class="fa fa-link"></i> Assign Subjects &amp; Classes
                                            </a>
                                        </div>
                                    </div>

                                    <div class="tab-pane" id="section-teachers">
                                        <div class="st-wrap">
                                            <div class="st-toolbar">
                                                <p class="text-muted" style="margin:0; font-size:13px; flex:1; min-width:200px;">
                                                    Assign which teacher teaches each subject in a specific section. Timetable only allows allocated teachers.
                                                </p>
                                                <div class="st-search">
                                                    <i class="fa fa-search"></i>
                                                    <input type="text" id="stSearch" placeholder="Search class, section, subject or teacher…">
                                                </div>
                                                <a href="{{ route('admin.academic.subjects.section_teacher') }}" class="btn btn-sm btn-success">
                                                    <i class="fa fa-user-plus"></i> Manage Allocations
                                                </a>
                                            </div>

                                            @if($sectionAllocationGroups->isEmpty())
                                                <div class="st-empty">
                                                    <i class="fa fa-inbox"></i>
                                                    No classes or sections found.
                                                </div>
                                            @else
                                                <div class="st-layout">
                                                    <aside class="st-sidebar" id="stSidebar">
                                                        @foreach($sectionAllocationGroups as $group)
                                                            <div class="st-class-group" data-class-name="{{ strtolower($group['name']) }}">
                                                                <div class="st-class-head">{{ $group['name'] }}</div>
                                                                <div class="st-section-list">
                                                                    @foreach($group['sections'] as $section)
                                                                        <button type="button"
                                                                            class="st-section-btn"
                                                                            data-panel="st-panel-{{ $section['key'] }}"
                                                                            data-search="{{ strtolower($group['name'] . ' ' . $section['name'] . ' ' . $section['allocations']->pluck('subject')->join(' ') . ' ' . $section['allocations']->pluck('teacher')->join(' ')) }}">
                                                                            Section {{ $section['name'] }}
                                                                            <span class="st-badge">{{ $section['count'] }}</span>
                                                                        </button>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </aside>

                                                    <div class="st-main">
                                                        @foreach($sectionAllocationGroups as $group)
                                                            @foreach($group['sections'] as $section)
                                                                <div class="st-panel" id="st-panel-{{ $section['key'] }}" style="display:none;">
                                                                    <div class="st-main-head">
                                                                        <h4>{{ $group['name'] }} — Section {{ $section['name'] }}</h4>
                                                                        <p>{{ $section['count'] }} {{ Str::plural('subject', $section['count']) }} allocated</p>
                                                                    </div>
                                                                    @if($section['allocations']->isEmpty())
                                                                        <div class="st-empty">
                                                                            <i class="fa fa-user-times"></i>
                                                                            No teachers allocated for this section yet.
                                                                        </div>
                                                                    @else
                                                                        <div class="st-subject-grid">
                                                                            @foreach($section['allocations'] as $row)
                                                                                <div class="st-subject-card">
                                                                                    <div class="st-subject-name">
                                                                                        {{ $row['subject'] }}
                                                                                        @if($row['code'])
                                                                                            <span class="st-subject-code">{{ $row['code'] }}</span>
                                                                                        @endif
                                                                                    </div>
                                                                                    <div class="st-teacher">
                                                                                        <i class="fa fa-user"></i>{{ $row['teacher'] }}
                                                                                    </div>
                                                                                </div>
                                                                            @endforeach
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            @endforeach
                                                        @endforeach
                                                        <div class="st-empty" id="stPanelPlaceholder">
                                                            <i class="fa fa-hand-pointer-o"></i>
                                                            Select a class section on the left to view allocations.
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                </div>{{-- /tab-content --}}
                            </div>
                        </div>
                    </div>
                            
                       
                </div>
            </div>
        </div>
    </div>

    @push('js')

        
        <script>
            $(document).ready(function() {
                // Section Teachers tab — class/section navigator
                function showStPanel(panelId) {
                    $('.st-panel').hide();
                    $('#stPanelPlaceholder').hide();
                    if (panelId && $('#' + panelId).length) {
                        $('#' + panelId).show();
                    } else {
                        $('#stPanelPlaceholder').show();
                    }
                }

                function activateStSection($btn) {
                    $('.st-section-btn').removeClass('active');
                    $btn.addClass('active');
                    showStPanel($btn.data('panel'));
                }

                var $firstSection = $('.st-section-btn:visible').first();
                if ($firstSection.length) {
                    activateStSection($firstSection);
                }

                $(document).on('click', '.st-section-btn:visible', function() {
                    activateStSection($(this));
                });

                $('a[href="#section-teachers"]').on('shown.bs.tab', function() {
                    if (!$('.st-section-btn.active:visible').length) {
                        var $visible = $('.st-section-btn:visible').first();
                        if ($visible.length) {
                            activateStSection($visible);
                        }
                    }
                });

                $('#stSearch').on('input', function() {
                    var q = $(this).val().toLowerCase().trim();
                    var $firstMatch = null;

                    $('.st-class-group').each(function() {
                        var classVisible = false;
                        $(this).find('.st-section-btn').each(function() {
                            var hay = $(this).data('search') || '';
                            var className = $(this).closest('.st-class-group').data('class-name') || '';
                            var match = !q || hay.indexOf(q) !== -1 || className.indexOf(q) !== -1;
                            $(this).toggle(match);
                            if (match && !$firstMatch) {
                                $firstMatch = $(this);
                            }
                            if (match) {
                                classVisible = true;
                            }
                        });
                        $(this).toggle(classVisible || !q);
                    });

                    if ($firstMatch && $firstMatch.length) {
                        activateStSection($firstMatch);
                    } else if (!q) {
                        $('#stPanelPlaceholder').html('<i class="fa fa-hand-pointer-o"></i> Select a class section on the left to view allocations.');
                        var $first = $('.st-section-btn:visible').first();
                        if ($first.length) {
                            activateStSection($first);
                        }
                    } else {
                        $('.st-section-btn').removeClass('active');
                        showStPanel(null);
                        $('#stPanelPlaceholder').html('<i class="fa fa-search"></i> No matching class, section, subject or teacher.').show();
                    }
                });

                $('#parentForm').submit(function(e) {
                    let isValid = true;
                    
                    // Clear previous errors
                    $('.is-invalid').removeClass('is-invalid');
                    $('.invalid-feedback').remove();
                    
                    // Validate emergency contact (must be numeric)
                    const emergencyContact = $('input[name="emergency_contact"]').val();
                    if (!emergencyContact || !/^\d+$/.test(emergencyContact)) {
                        $('input[name="emergency_contact"]').addClass('is-invalid');
                        $('input[name="emergency_contact"]').after(
                            '<div class="invalid-feedback">Please enter a valid phone number (digits only)</div>'
                        );
                        isValid = false;
                    }
                    
                    // Validate required fields
                    $('[required]').each(function() {
                        if (!$(this).val()) {
                            $(this).addClass('is-invalid');
                            $(this).after(
                                '<div class="invalid-feedback">This field is required</div>'
                            );
                            isValid = false;
                        }
                    });
                    
                    // Validate at least one child selected
                    if ($('.chosen-select option:selected').length === 0) {
                        $('.chosen-select').addClass('is-invalid');
                        $('.chosen-select').after(
                            '<div class="invalid-feedback">Please select at least one child</div>'
                        );
                        isValid = false;
                    }
                    
                    if (!isValid) {
                        e.preventDefault();
                        $('html, body').animate({
                            scrollTop: $('.is-invalid').first().offset().top - 100
                        }, 500);
                    }
                });
            });
        </script>
        
    <!-- Additional JS for school profile -->
    <script>
        $(document).ready(function() {
            // Initialize tabs
            $('.profile-tabs .nav-tabs a').click(function(e) {
                e.preventDefault();
                $(this).tab('show');
            });
            
            // Load charts or other dynamic content if needed
            // Example: loadStudentDistributionChart();
        });
        
        function loadStudentDistributionChart() {
            // This would be an AJAX call to get data for a chart
            // Example implementation would go here
        }
    </script>
    @endpush
    
</x-tenant-app-layout>