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
        <link rel="stylesheet" href="{{ asset('backend/style.css') }}">
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
                            <ul class="breadcome-menu">
                                <li>
                                    <a href="{{ route('schools.cms') }}" class="btn btn-primary btn-sm" style="color: white">
                                        <i class="fa fa-graduation-cap"></i> CMS
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('schools.edit') }}" class="btn btn-primary btn-sm" style="color: white">
                                        <i class="fa fa-graduation-cap"></i> Profile Edit
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('schools.settings') }}" class="btn btn-primary btn-sm" style="color: white">
                                        <i class="fa fa-cog"></i> Setting
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="sparkline12-list">
  
                            
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <div class="text-center">
                                <div class="logo-container mx-auto">
                                    @if(isset($school->logo))
                                        <img src="{{ asset($school->logo) }}" alt="School Logo" class="img-fluid">
                                    @else
                                        <img src="{{ asset('backend/img/school-default.png') }}" alt="School Logo" class="img-fluid">
                                    @endif
                                </div>
                                <h3 class="mt-3">{{ $school->name??"" }}</h3>
                                <p class="text-muted">{{ $school->session_year??"" }} Session</p>
                            </div>
                            
                            <div class="mt-4">
                                <h4>Quick Stats</h4>
                                <div class="stat-card" style="background-color: #4e73df;">
                                    <i class="fa fa-users"></i>
                                    <h3>{{ $stats['students']??"" }}</h3>
                                    <p>Total Students</p>
                                </div>
                                <div class="stat-card" style="background-color: #1cc88a;">
                                    <i class="fa fa-chalkboard-teacher"></i>
                                    <h3>{{ $stats['teachers']??"" }}</h3>
                                    <p>Teaching Staff</p>
                                </div>
                                <div class="stat-card" style="background-color: #36b9cc;">
                                    <i class="fa fa-door-open"></i>
                                    <h3>{{ $stats['classes']??"" }}</h3>
                                    <p>Classes</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                            <div class="profile-tabs">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#basic" data-toggle="tab">Basic Information</a></li>
                                    <li><a href="#contact" data-toggle="tab">Contact Details</a></li>
                                    <li><a href="#academic" data-toggle="tab">Academic Structure</a></li>
                                </ul>
                                
                                <div class="tab-content">
                                    <div class="tab-pane active" id="basic">
                                        <table class="profile-info table">
                                            <tr>
                                                <td>School Name</td>
                                                <td>{{ $school->name??"" }}</td>
                                            </tr>
                                            <tr>
                                                <td>Academic Session</td>
                                                <td>{{ $school->session_year??"" }}</td>
                                            </tr>
                                            <tr>
                                                <td>Established</td>
                                                <td>{{ $school->established_year ?? 'Not specified' }}</td>
                                            </tr>
                                            <tr>
                                                <td>School Type</td>
                                                <td>{{ $school->type ?? 'Not specified' }}</td>
                                            </tr>
                                            <tr>
                                                <td>Affiliation</td>
                                                <td>{{ $school->affiliation ?? 'Not specified' }}</td>
                                            </tr>
                                            <tr>
                                                <td>Principal</td>
                                                <td>{{ $school->principal ?? 'Not specified' }}</td>
                                            </tr>
                                            <tr>
                                                <td>About School</td>
                                                <td>{{ $school->about ?? 'Not specified' }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                    
                                    <div class="tab-pane" id="contact">
                                        <table class="profile-info table">
                                            <tr>
                                                <td>Address</td>
                                                <td>{{ $school->address ?? ""}}</td>
                                            </tr>
                                            <tr>
                                                <td>Phone Number</td>
                                                <td>{{ $school->phone??"" }}</td>
                                            </tr>
                                            <tr>
                                                <td>Email Address</td>
                                                <td>{{ $school->email??"" }}</td>
                                            </tr>
                                            <tr>
                                                <td>Website</td>
                                                <td>{{ $school->website ?? 'Not specified' }}</td>
                                            </tr>
                                            <tr>
                                                <td>Social Media</td>
                                                <td>
                                                    @if(isset($school->social_links))
                                                        @foreach(json_decode($school->social_links) as $platform => $link)
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
                                            <tr>
                                                <td>School Hours</td>
                                                <td>{{ $school->working_hours ?? 'Not specified' }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                    
                                    <div class="tab-pane " id="academic">
                                        <div class="row">
                                            <div class="col-md-6" style="margin-top: 20px">
                                                <h4>Classes & Sections</h4>
                                                <div class="table-responsive">
                                                    <table class="table table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>Class</th>
                                                                <th>Sections</th>
                                                                {{-- <th>Class Teacher</th> --}}
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($classes as $class)
                                                            <tr>
                                                                <td>{{ $class->name??"" }}</td>
                                                                <td>
                                                                    @foreach($class->sections as $section)
                                                                        <span class="badge badge-primary">{{ $section->name??"" }}</span>
                                                                    @endforeach
                                                                </td>
                                                                {{-- <td>
                                                                    @foreach ($class->classTeachersSubjects as $subject)
                                                                        @if ($subject->class_id == $class->id)
                                                                            <span class="badge badge-primary">{{ $subject->teacher->name }}</span>
                                                                        @endif  
                                                                    @endforeach
                                                                </td> --}}
                                                            </tr>
                                                            @endforeach
                                                            
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <h4>Subjects Offered</h4>
                                                <div class="table-responsive">
                                                    <table class="table table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>Subject</th>
                                                                <th>Code</th>
                                                                {{-- <th>Classes</th> --}}
                                                                {{-- <th>Teacher</th> --}}
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($subjects as $subject)
                                                            <tr>
                                                                <td>{{ $subject->name??"" }}</td>
                                                                <td>{{ $subject->code ?? '-' }}</td>
                                                                {{-- <td>
                                                                    @if($subject->teacherSubjects && $subject->teacherSubjects->count())
                                                                        @foreach($subject->teacherSubjects as $class)
                                                                            <span class="badge badge-info">{{ $class->class->name??"" }}</span>
                                                                        @endforeach
                                                                    @else
                                                                        Not assigned
                                                                    @endif
                                                                </td> --}}
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                            
                       
                </div>
            </div>
        </div>
    </div>

    @push('js')

        <!-- jquery============================================ -->
        <script src="{{ asset('backend/js/vendor/jquery-1.12.4.min.js') }}"></script>
        <!-- bootstrap JS============================================ -->
        <script src="{{ asset('backend/js/bootstrap.min.js') }}"></script>
        <!-- wow JS============================================ -->
        <script src="{{ asset('backend/js/wow.min.js') }}"></script>
        <!-- price-slider JS============================================ -->
        <script src="{{ asset('backend/js/jquery-price-slider.js') }}"></script>
        <!-- meanmenu JS============================================ -->
        <script src="{{ asset('backend/js/jquery.meanmenu.js') }}"></script>
        <!-- owl.carousel JS============================================ -->
        <script src="{{ asset('backend/js/owl.carousel.min.js') }}"></script>
        <!-- sticky JS============================================ -->
        <script src="{{ asset('backend/js/jquery.sticky.js') }}"></script>
        <!-- scrollUp JS============================================ -->
        <script src="{{ asset('backend/js/jquery.scrollUp.min.js') }}"></script>
        <!-- mCustomScrollbar JS============================================ -->
        <script src="{{ asset('backend/js/scrollbar/jquery.mCustomScrollbar.concat.min.js') }}"></script>
        <script src="{{ asset('backend/js/scrollbar/mCustomScrollbar-active.js') }}"></script>
        <!-- metisMenu JS============================================ -->
        <script src="{{ asset('backend/js/metisMenu/metisMenu.min.js') }}"></script>
        <script src="{{ asset('backend/js/metisMenu/metisMenu-active.js') }}"></script>
        <!-- touchspin JS============================================ -->
        <script src="{{ asset('backend/js/touchspin/jquery.bootstrap-touchspin.min.js') }}"></script>
        <script src="{{ asset('backend/js/touchspin/touchspin-active.js') }}"></script>
        <!-- colorpicker JS============================================ -->
        <script src="{{ asset('backend/js/colorpicker/jquery.spectrum.min.js') }}"></script>
        <script src="{{ asset('backend/js/colorpicker/color-picker-active.js') }}"></script>
        <!-- datapicker JS============================================ -->
        <script src="{{ asset('backend/js/datapicker/bootstrap-datepicker.js') }}"></script>
        <script src="{{ asset('backend/js/datapicker/datepicker-active.js') }}"></script>
        <!-- input-mask JS============================================ -->
        <script src="{{ asset('backend/js/input-mask/jasny-bootstrap.min.js') }}"></script>
        <!-- chosen JS============================================ -->
        <script src="{{ asset('backend/js/chosen/chosen.jquery.js') }}"></script>
        <script src="{{ asset('backend/js/chosen/chosen-active.js') }}"></script>
        <!-- select2 JS============================================ -->
        <script src="{{ asset('backend/js/select2/select2.full.min.js') }}"></script>
        <script src="{{ asset('backend/js/select2/select2-active.js') }}"></script>
        <!-- ionRangeSlider JS============================================ -->
        <script src="{{ asset('backend/js/ionRangeSlider/ion.rangeSlider.min.js') }}"></script>
        <script src="{{ asset('backend/js/ionRangeSlider/ion.rangeSlider.active.js') }}"></script>
        <!-- rangle-slider JS============================================ -->
        <script src="{{ asset('backend/js/rangle-slider/jquery-ui-1.10.4.custom.min.js') }}"></script>
        <script src="{{ asset('backend/js/rangle-slider/jquery-ui-touch-punch.min.js') }}"></script>
        <script src="{{ asset('backend/js/rangle-slider/rangle-active.js') }}"></script>
        <!-- knob JS============================================ -->
        <script src="{{ asset('backend/js/knob/jquery.knob.js') }}"></script>
        <script src="{{ asset('backend/js/knob/knob-active.js') }}"></script>
        <!-- tab JS============================================ -->
        <script src="{{ asset('backend/js/tab.js') }}"></script>
        <!-- plugins JS============================================ -->
        <script src="{{ asset('backend/js/plugins.js') }}"></script>
        <!-- main JS============================================ -->
        <script src="{{ asset('backend/js/main.js') }}"></script>
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