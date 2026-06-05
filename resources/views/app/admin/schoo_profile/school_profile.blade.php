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
        </style>

    @endpush

    <x-slot name="header"></x-slot>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="breadcome-list">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="breadcome-heading" style="margin-top: 10px">
                                <h3>School Profile</h3>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="action-buttons">
                                <a href="{{ route('schools.show') }}" class="btn btn-primary btn-sm" style="color: white">
                                    <i class="fa fa-building"></i>  Profile
                                </a>
                                <a href="{{ route('schools.cms') }}" class="btn btn-primary btn-sm" style="color: white">
                                    CMS
                                </a>
                                <a href="{{ route('schools.edit') }}" class="btn btn-primary btn-sm" style="color: white">
                                    <i class="fa fa-graduation-cap"></i> Profile Edit
                                </a>
                                <a href="{{ route('schools.settings') }}" class="btn btn-primary btn-sm" style="color: white">
                                    <i class="fa fa-cog"></i> Setting
                                </a>
                            </div>
                        </div>
                        <div class="dropdown-container">
                            <button class="dropdown-toggle-custom">
                                <i class="fa fa-ellipsis-v"></i>
                            </button>
                            <div class="dropdown-menu-custom">
                                <a href="{{ route('schools.cms') }}" class="btn btn-primary btn-sm" style="color: white">
                                    <i class="fa fa-graduation-cap"></i> CMS
                                </a>
                                <a href="{{ route('schools.edit') }}" class="btn btn-primary btn-sm" style="color: white">
                                    <i class="fa fa-graduation-cap"></i> Profile Edit
                                </a>
                                <a href="{{ route('schools.settings') }}" class="btn btn-primary btn-sm" style="color: white">
                                    <i class="fa fa-cog"></i> Setting
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
                                    <li><a href="#teachers-subjects" data-toggle="tab"><i class="fa fa-user"></i> Teachers &amp; Subjects</a></li>
                                    <li><a href="#teachers-classes" data-toggle="tab"><i class="fa fa-users"></i> Teachers &amp; Classes</a></li>
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
                                    </div>

                                    {{-- Teachers & Subjects --}}
                                    <div class="tab-pane" id="teachers-subjects">
                                        <div class="table-responsive" style="margin-top: 15px;">
                                            <table class="table table-striped table-bordered">
                                                <thead style="background:#f5f5f5;">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Teacher</th>
                                                        <th>Subjects Assigned</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($teachers as $i => $teacher)
                                                        <tr>
                                                            <td>{{ $i + 1 }}</td>
                                                            <td><strong>{{ $teacher->name }}</strong></td>
                                                            <td>
                                                                @if($teacher->teacherSubjects->isNotEmpty())
                                                                    @foreach($teacher->teacherSubjects as $subject)
                                                                        <span class="label label-primary" style="margin-right:4px;">
                                                                            {{ $subject->name }}
                                                                        </span>
                                                                    @endforeach
                                                                @else
                                                                    <span class="text-muted">No subjects assigned</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="3" class="text-muted text-center">No teachers found</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    {{-- Teachers & Classes --}}
                                    <div class="tab-pane" id="teachers-classes">
                                        <div class="table-responsive" style="margin-top: 15px;">
                                            <table class="table table-striped table-bordered">
                                                <thead style="background:#f5f5f5;">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Teacher</th>
                                                        <th>Class Teacher Of</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($teachers as $i => $teacher)
                                                        <tr>
                                                            <td>{{ $i + 1 }}</td>
                                                            <td><strong>{{ $teacher->name }}</strong></td>
                                                            <td>
                                                                @if($teacher->teacherProfile && $teacher->teacherProfile->classTeacherOf)
                                                                    <span class="label label-success">
                                                                        {{ $teacher->teacherProfile->classTeacherOf->name }}
                                                                    </span>
                                                                @else
                                                                    <span class="text-muted">Not a class teacher</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="3" class="text-muted text-center">No teachers found</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
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