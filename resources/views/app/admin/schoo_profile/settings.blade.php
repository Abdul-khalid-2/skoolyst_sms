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
        <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">

        <style>
            .settings-card {
                border-radius: 5px;
                padding: 20px;
                margin-bottom: 20px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
                background: #fff;
            }

            .settings-card h4 {
                border-bottom: 1px solid #eee;
                padding-bottom: 10px;
                margin-bottom: 20px;
            }

            .settings-group {
                margin-bottom: 15px;
            }

            .settings-label {
                font-weight: 600;
                margin-bottom: 5px;
            }
            
            .nav-tabs.tabs-left > li.active > a {
                border-left: 3px solid #4a90e2;
                background-color: #f5f9fc;
            }
            
            .nav-tabs.tabs-left > li > a {
                padding: 15px 20px;
                border-radius: 0;
            }
            
            .tab-content {
                padding: 20px;
                background: #fff;
                border: 1px solid #ddd;
                border-left: none;
            }
        </style>
    @endpush

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('School Settings') }}
        </h2>
    </x-slot>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="breadcome-list">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="breadcome-heading" style="margin-top: 10px">
                                <h3>School Setting</h3>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="action-buttons">
                                <a href="{{ route('schools.show') }}" class="btn btn-primary btn-sm" style="color: white">
                                    <i class="fa fa-arrow-left"></i> Back
                                </a>
                            </div>
                            <div class="dropdown-container">
                                <button class="dropdown-toggle-custom">
                                    <i class="fa fa-ellipsis-v"></i>
                                </button>
                                <div class="dropdown-menu-custom">
                                    <a href="{{ route('schools.show') }}" class="btn btn-primary btn-sm" style="color: white">
                                        <i class="fa fa-arrow-left"></i> Back
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="sparkline12-list">
                    <div class="sparkline12-hd">
                        <div class="main-sparkline12-hd">
                            <h1>School Profile</h1>
                        </div>
                    </div>
                    <div class="sparkline12-graph">
                        <div class="basic-login-form-ad">
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    <div class="settings-menu">
                                        <ul class="nav nav-tabs tabs-left">
                                            <li class="active"><a href="#basic-info" data-toggle="tab"><i class="fa fa-info-circle"></i> Basic Information</a></li>
                                            <li><a href="#contact-details" data-toggle="tab"><i class="fa fa-address-book"></i> Contact Details</a></li>
                                            <li><a href="#academic-structure" data-toggle="tab"><i class="fa fa-sitemap"></i> Academic Structure</a></li>
                                            <li><a href="#general" data-toggle="tab"><i class="fa fa-cog"></i> System Settings</a></li>
                                            <li><a href="#academic" data-toggle="tab"><i class="fa fa-graduation-cap"></i> Academic Settings</a></li>
                                            <li><a href="#attendance" data-toggle="tab"><i class="fa fa-calendar-check"></i> Attendance Settings</a></li>
                                            <li><a href="#fee" data-toggle="tab"><i class="fa fa-money-bill-wave"></i> Fee Settings</a></li>
                                            <li><a href="#notifications" data-toggle="tab"><i class="fa fa-bell"></i> Notifications</a></li>
                                            <li><a href="#security" data-toggle="tab"><i class="fa fa-shield-alt"></i> Security</a></li>
                                        </ul>
                                    </div>
                                </div>
    
                                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                    <div class="tab-content">
                                        <!-- Basic Information Tab -->
                                        <div class="tab-pane active" id="basic-info">
                                            <form action="{{ route('schools.update-basic-info') }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                
                                                <div class="settings-card">
                                                    <h4>School Identity</h4>
                                                    
                                                    <div class="settings-group">
                                                        <label class="settings-label">School Logo</label>
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                @if($school->logo)
                                                                    <img src="{{ asset('storage/'.$school->logo) }}" alt="School Logo" class="img-thumbnail" style="max-height: 100px;">
                                                                @else
                                                                    <div class="no-logo-placeholder" style="width: 100px; height: 100px; background: #eee; display: flex; align-items: center; justify-content: center;">
                                                                        No Logo
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input type="file" name="logo" class="form-control">
                                                                <small class="text-muted">Recommended size: 300x300 pixels</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="settings-group">
                                                        <label class="settings-label">School Name</label>
                                                        <input type="text" name="name" class="form-control" value="{{ old('name', $school->name) }}" required>
                                                    </div>
                                                    
                                                    <div class="settings-group">
                                                        <label class="settings-label">Academic Section</label>
                                                        <select name="academic_section" class="form-control" required>
                                                            <option value="primary" {{ old('academic_section', $school->academic_section) == 'primary' ? 'selected' : '' }}>Primary School</option>
                                                            <option value="secondary" {{ old('academic_section', $school->academic_section) == 'secondary' ? 'selected' : '' }}>Secondary School</option>
                                                            <option value="both" {{ old('academic_section', $school->academic_section) == 'both' ? 'selected' : '' }}>Both Primary & Secondary</option>
                                                        </select>
                                                    </div>
                                                    
                                                    <div class="settings-group">
                                                        <label class="settings-label">Established Year</label>
                                                        <input type="number" name="established_year" class="form-control" value="{{ old('established_year', $school->established_year) }}" min="1900" max="{{ date('Y') }}">
                                                    </div>
                                                    
                                                    <div class="settings-group">
                                                        <label class="settings-label">School Type</label>
                                                        <select name="school_type" class="form-control" required>
                                                            <option value="public" {{ old('school_type', $school->school_type) == 'public' ? 'selected' : '' }}>Public</option>
                                                            <option value="private" {{ old('school_type', $school->school_type) == 'private' ? 'selected' : '' }}>Private</option>
                                                            <option value="international" {{ old('school_type', $school->school_type) == 'international' ? 'selected' : '' }}>International</option>
                                                        </select>
                                                    </div>
                                                    
                                                    <div class="settings-group">
                                                        <label class="settings-label">Affiliation Number</label>
                                                        <input type="text" name="affiliation_number" class="form-control" value="{{ old('affiliation_number', $school->affiliation_number) }}">
                                                    </div>
                                                    
                                                    <div class="settings-group">
                                                        <label class="settings-label">Principal/Headmaster</label>
                                                        <input type="text" name="principal" class="form-control" value="{{ old('principal', $school->principal) }}">
                                                    </div>
                                                    
                                                    <div class="settings-group">
                                                        <label class="settings-label">About School</label>
                                                        <textarea name="about" class="form-control" rows="4">{{ old('about', $school->about) }}</textarea>
                                                    </div>
                                                </div>
                                                
                                                <div class="text-right">
                                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                                </div>
                                            </form>
                                        </div>
                                        
                                        <!-- Contact Details Tab -->
                                        <div class="tab-pane" id="contact-details">
                                            <form action="{{ route('schools.update-contact-details') }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                
                                                <div class="settings-card">
                                                    <h4>Address Information</h4>
                                                    
                                                    <div class="settings-group">
                                                        <label class="settings-label">Address Line 1</label>
                                                        <input type="text" name="address_line1" class="form-control" value="{{ old('address_line1', $school->address_line1) }}" required>
                                                    </div>
                                                    
                                                    <div class="settings-group">
                                                        <label class="settings-label">Address Line 2</label>
                                                        <input type="text" name="address_line2" class="form-control" value="{{ old('address_line2', $school->address_line2) }}">
                                                    </div>
                                                    
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="settings-group">
                                                                <label class="settings-label">City</label>
                                                                <input type="text" name="city" class="form-control" value="{{ old('city', $school->city) }}" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="settings-group">
                                                                <label class="settings-label">State/Province</label>
                                                                <input type="text" name="state" class="form-control" value="{{ old('state', $school->state) }}" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="settings-group">
                                                                <label class="settings-label">Postal Code</label>
                                                                <input type="text" name="postal_code" class="form-control" value="{{ old('postal_code', $school->postal_code) }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="settings-group">
                                                        <label class="settings-label">Country</label>
                                                        <select name="country" class="form-control" required>
                                                            @foreach($countries as $country)
                                                                <option value="{{ $country->code }}" {{ old('country', $school->country) == $country->code ? 'selected' : '' }}>
                                                                    {{ $country->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                
                                                <div class="settings-card">
                                                    <h4>Contact Information</h4>
                                                    
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="settings-group">
                                                                <label class="settings-label">Phone Number</label>
                                                                <input type="tel" name="phone" class="form-control" value="{{ old('phone', $school->phone) }}" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="settings-group">
                                                                <label class="settings-label">Alternative Phone</label>
                                                                <input type="tel" name="alt_phone" class="form-control" value="{{ old('alt_phone', $school->alt_phone) }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="settings-group">
                                                                <label class="settings-label">Email Address</label>
                                                                <input type="email" name="email" class="form-control" value="{{ old('email', $school->email) }}" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="settings-group">
                                                                <label class="settings-label">Website</label>
                                                                <input type="url" name="website" class="form-control" value="{{ old('website', $school->website) }}" placeholder="https://">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="settings-card">
                                                    <h4>Social Media</h4>
                                                    
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="settings-group">
                                                                <label class="settings-label">Facebook</label>
                                                                <input type="url" name="facebook_url" class="form-control" value="{{ old('facebook_url', $school->facebook_url) }}" placeholder="https://facebook.com/">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="settings-group">
                                                                <label class="settings-label">Twitter</label>
                                                                <input type="url" name="twitter_url" class="form-control" value="{{ old('twitter_url', $school->twitter_url) }}" placeholder="https://twitter.com/">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="settings-group">
                                                                <label class="settings-label">Instagram</label>
                                                                <input type="url" name="instagram_url" class="form-control" value="{{ old('instagram_url', $school->instagram_url) }}" placeholder="https://instagram.com/">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="settings-group">
                                                                <label class="settings-label">LinkedIn</label>
                                                                <input type="url" name="linkedin_url" class="form-control" value="{{ old('linkedin_url', $school->linkedin_url) }}" placeholder="https://linkedin.com/">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="settings-card">
                                                    <h4>School Hours</h4>
                                                    
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="settings-group">
                                                                <label class="settings-label">Opening Time</label>
                                                                <input type="time" name="opening_time" class="form-control" value="{{ old('opening_time', $school->opening_time ? \Carbon\Carbon::parse($school->opening_time)->format('H:i') : '08:00') }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="settings-group">
                                                                <label class="settings-label">Closing Time</label>
                                                                <input type="time" name="closing_time" class="form-control" value="{{ old('closing_time', $school->closing_time ? \Carbon\Carbon::parse($school->closing_time)->format('H:i') : '15:00') }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="text-right">
                                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                                </div>
                                            </form>
                                        </div>
                                        
                                        <!-- Academic Structure Tab -->
                                        <div class="tab-pane" id="academic-structure">
                                            <form action="{{ route('schools.update-academic-structure') }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                
                                                <div class="settings-card">
                                                    <h4>Academic Levels</h4>
                                                    
                                                    <div class="settings-group">
                                                        <label class="settings-label">Education System</label>
                                                        <select name="education_system" class="form-control" required>
                                                            <option value="american" {{ old('education_system', $school->education_system) == 'american' ? 'selected' : '' }}>American System</option>
                                                            <option value="british" {{ old('education_system', $school->education_system) == 'british' ? 'selected' : '' }}>British System</option>
                                                            <option value="ib" {{ old('education_system', $school->education_system) == 'ib' ? 'selected' : '' }}>International Baccalaureate (IB)</option>
                                                            <option value="cbse" {{ old('education_system', $school->education_system) == 'cbse' ? 'selected' : '' }}>CBSE (India)</option>
                                                            <option value="icse" {{ old('education_system', $school->education_system) == 'icse' ? 'selected' : '' }}>ICSE (India)</option>
                                                            <option value="other" {{ old('education_system', $school->education_system) == 'other' ? 'selected' : '' }}>Other</option>
                                                        </select>
                                                    </div>
                                                    
                                                    <div class="settings-group">
                                                        <label class="settings-label">Academic Year Structure</label>
                                                        <select name="academic_year_structure" class="form-control" required>
                                                            <option value="semester" {{ old('academic_year_structure', $school->academic_year_structure) == 'semester' ? 'selected' : '' }}>Semester System (2 terms)</option>
                                                            <option value="trimester" {{ old('academic_year_structure', $school->academic_year_structure) == 'trimester' ? 'selected' : '' }}>Trimester System (3 terms)</option>
                                                            <option value="quarter" {{ old('academic_year_structure', $school->academic_year_structure) == 'quarter' ? 'selected' : '' }}>Quarter System (4 terms)</option>
                                                        </select>
                                                    </div>
                                                    
                                                    <div class="settings-group">
                                                        <label class="settings-label">Available Grades/Classes</label>
                                                        <div class="row">
                                                            @foreach($availableGrades as $grade)
                                                                <div class="col-md-3">
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input type="checkbox" name="grades[]" value="{{ $grade->id }}" 
                                                                                {{ in_array($grade->id, $schoolGrades) ? 'checked' : '' }}>
                                                                            {{ $grade->name }}
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="settings-group">
                                                        <label class="settings-label">Available Subjects</label>
                                                        <div class="row">
                                                            @foreach($availableSubjects as $subject)
                                                                <div class="col-md-3">
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input type="checkbox" name="subjects[]" value="{{ $subject->id }}" 
                                                                                {{ in_array($subject->id, $schoolSubjects) ? 'checked' : '' }}>
                                                                            {{ $subject->name }}
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="text-right">
                                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                                </div>
                                            </form>
                                        </div>
    
                                        <!-- System Settings Tab -->
                                        <div class="tab-pane" id="general">
                                            <form action="{{ route('schools.update-settings') }}" method="POST">
                                                @csrf
                                                @method('PUT')
    
                                                <div class="settings-card">
                                                    <h4>Basic Information</h4>
    
                                                    <div class="settings-group">
                                                        <label class="settings-label">Time Zone</label>
                                                        <select name="timezone" class="form-control" required>
                                                            @foreach(timezone_identifiers_list() as $tz)
                                                            <option value="{{ $tz }}" {{ ($settings['timezone'] ?? 'UTC') == $tz ? 'selected' : '' }}>
                                                                {{ $tz }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
    
                                                    <div class="settings-group">
                                                        <label class="settings-label">Date Format</label>
                                                        <select name="date_format" class="form-control" required>
                                                            <option value="d/m/Y" {{ ($settings['date_format'] ?? 'd/m/Y') == 'd/m/Y' ? 'selected' : '' }}>
                                                                DD/MM/YYYY</option>
                                                            <option value="m/d/Y" {{ ($settings['date_format'] ?? 'd/m/Y') == 'm/d/Y' ? 'selected' : '' }}>
                                                                MM/DD/YYYY</option>
                                                            <option value="Y-m-d" {{ ($settings['date_format'] ?? 'd/m/Y') == 'Y-m-d' ? 'selected' : '' }}>
                                                                YYYY-MM-DD</option>
                                                        </select>
                                                    </div>
                                                    
                                                    <div class="settings-group">
                                                        <label class="settings-label">Language</label>
                                                        <select name="language" class="form-control" required>
                                                            <option value="en" {{ ($settings['language'] ?? 'en') == 'en' ? 'selected' : '' }}>English</option>
                                                            <option value="es" {{ ($settings['language'] ?? 'en') == 'es' ? 'selected' : '' }}>Spanish</option>
                                                            <option value="fr" {{ ($settings['language'] ?? 'en') == 'fr' ? 'selected' : '' }}>French</option>
                                                            <option value="ar" {{ ($settings['language'] ?? 'en') == 'ar' ? 'selected' : '' }}>Arabic</option>
                                                            <option value="zh" {{ ($settings['language'] ?? 'en') == 'zh' ? 'selected' : '' }}>Chinese</option>
                                                        </select>
                                                    </div>
                                                    
                                                    <div class="settings-group">
                                                        <label class="settings-label">Enable Dark Mode</label>
                                                        <div class="toggle-switch">
                                                            <input type="checkbox" name="dark_mode" id="dark_mode" {{ ($settings['dark_mode'] ?? false) ? 'checked' : '' }}>
                                                            <label for="dark_mode">Enable dark theme</label>
                                                        </div>
                                                    </div>
                                                </div>
    
                                                <div class="text-right">
                                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                                </div>
                                            </form>
                                        </div>
    
                                        <!-- Academic Settings Tab -->
                                        <div class="tab-pane" id="academic">
                                            <form action="{{ route('schools.update-academic-settings') }}" method="POST">
                                                @csrf
                                                @method('PUT')
    
                                                <div class="settings-card">
                                                    <h4>Academic Configuration</h4>
    
                                                    <div class="settings-group">
                                                        <label>Working Hours</label>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label class="small">From Time</label>
                                                                <input type="time" name="working_hours_start" class="form-control @error('working_hours_start') is-invalid @enderror" value="{{ old('working_hours_start', $settings['working_hours_start'] ?? '08:00') }}">
                                                                @error('working_hours_start')
                                                                <div class="invalid-feedback" style="color: red">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="small">To Time</label>
                                                                <input type="time" name="working_hours_end" class="form-control @error('working_hours_end') is-invalid @enderror" value="{{ old('working_hours_end', $settings['working_hours_end'] ?? '15:00') }}">
                                                                @error('working_hours_end')
                                                                <div class="invalid-feedback" style="color: red">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
    
                                                    <div class="settings-group">
                                                        <label>Working Days</label>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label class="small">From Day</label>
                                                                <select name="working_days_start" class="form-control @error('working_days_start') is-invalid @enderror">
                                                                    <option value="Monday" {{ old('working_days_start', $settings['working_days_start'] ?? 'Monday') == 'Monday' ? 'selected' : '' }}>
                                                                        Monday</option>
                                                                    <option value="Tuesday" {{ old('working_days_start', $settings['working_days_start'] ?? 'Monday') == 'Tuesday' ? 'selected' : '' }}>
                                                                        Tuesday</option>
                                                                    <option value="Wednesday" {{ old('working_days_start', $settings['working_days_start'] ?? 'Monday') == 'Wednesday' ? 'selected' : '' }}>
                                                                        Wednesday</option>
                                                                    <option value="Thursday" {{ old('working_days_start', $settings['working_days_start'] ?? 'Monday') == 'Thursday' ? 'selected' : '' }}>
                                                                        Thursday</option>
                                                                    <option value="Friday" {{ old('working_days_start', $settings['working_days_start'] ?? 'Monday') == 'Friday' ? 'selected' : '' }}>
                                                                        Friday</option>
                                                                    <option value="Saturday" {{ old('working_days_start', $settings['working_days_start'] ?? 'Monday') == 'Saturday' ? 'selected' : '' }}>
                                                                        Saturday</option>
                                                                    <option value="Sunday" {{ old('working_days_start', $settings['working_days_start'] ?? 'Monday') == 'Sunday' ? 'selected' : '' }}>
                                                                        Sunday</option>
                                                                </select>
                                                                @error('working_days_start')
                                                                <div class="invalid-feedback" style="color: red">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="small">To Day</label>
                                                                <select name="working_days_end" class="form-control @error('working_days_end') is-invalid @enderror">
                                                                    <option value="Monday" {{ old('working_days_end', $settings['working_days_end'] ?? 'Friday') == 'Monday' ? 'selected' : '' }}>
                                                                        Monday</option>
                                                                    <option value="Tuesday" {{ old('working_days_end', $settings['working_days_end'] ?? 'Friday') == 'Tuesday' ? 'selected' : '' }}>
                                                                        Tuesday</option>
                                                                    <option value="Wednesday" {{ old('working_days_end', $settings['working_days_end'] ?? 'Friday') == 'Wednesday' ? 'selected' : '' }}>
                                                                        Wednesday</option>
                                                                    <option value="Thursday" {{ old('working_days_end', $settings['working_days_end'] ?? 'Friday') == 'Thursday' ? 'selected' : '' }}>
                                                                        Thursday</option>
                                                                    <option value="Friday" {{ old('working_days_end', $settings['working_days_end'] ?? 'Friday') == 'Friday' ? 'selected' : '' }}>
                                                                        Friday</option>
                                                                    <option value="Saturday" {{ old('working_days_end', $settings['working_days_end'] ?? 'Friday') == 'Saturday' ? 'selected' : '' }}>
                                                                        Saturday</option>
                                                                    <option value="Sunday" {{ old('working_days_end', $settings['working_days_end'] ?? 'Friday') == 'Sunday' ? 'selected' : '' }}>
                                                                        Sunday</option>
                                                                </select>
                                                                @error('working_days_end')
                                                                <div class="invalid-feedback" style="color: red">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
    
                                                    <div class="settings-group">
                                                        <label class="settings-label">Grading System</label>
                                                        <select name="grading_system" class="form-control" required>
                                                            <option value="percentage" {{ ($settings['grading_system'] ?? 'percentage') == 'percentage' ? 'selected' : '' }}>
                                                                Percentage</option>
                                                            <option value="letter" {{ ($settings['grading_system'] ?? 'percentage') == 'letter' ? 'selected' : '' }}>
                                                                Letter Grades</option>
                                                            <option value="gpa" {{ ($settings['grading_system'] ?? 'percentage') == 'gpa' ? 'selected' : '' }}>
                                                                GPA Scale</option>
                                                        </select>
                                                    </div>
    
                                                    <div class="settings-group">
                                                        <label class="settings-label">Default Class Capacity</label>
                                                        <input type="number" name="default_class_capacity" class="form-control" value="{{ $settings['default_class_capacity'] ?? 30 }}" min="10" max="60">
                                                    </div>
    
                                                    <div class="settings-group">
                                                        <label class="settings-label">Enable Automatic Promotion</label>
                                                        <div class="toggle-switch">
                                                            <input type="checkbox" name="auto_promotion" id="auto_promotion" {{ ($settings['auto_promotion'] ?? false) ? 'checked' : '' }}>
                                                            <label for="auto_promotion">Enable at end of session</label>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="settings-group">
                                                        <label class="settings-label">Minimum Attendance Percentage</label>
                                                        <input type="number" name="min_attendance_percentage" class="form-control" value="{{ $settings['min_attendance_percentage'] ?? 75 }}" min="50" max="100">
                                                        <small class="text-muted">Students below this percentage will be marked as deficient</small>
                                                    </div>
                                                    
                                                    <div class="settings-group">
                                                        <label class="settings-label">Passing Percentage</label>
                                                        <input type="number" name="passing_percentage" class="form-control" value="{{ $settings['passing_percentage'] ?? 50 }}" min="30" max="100">
                                                    </div>
                                                </div>
    
                                                <div class="text-right">
                                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                                </div>
                                            </form>
                                        </div>
    
                                        <!-- Attendance Settings Tab -->
                                        <div class="tab-pane" id="attendance">
                                            <form action="{{ route('schools.update-attendance-settings') }}" method="POST">
                                                @csrf
                                                @method('PUT')
    
                                                <div class="settings-card">
                                                    <h4>Attendance Configuration</h4>
    
                                                    <div class="settings-group">
                                                        <label class="settings-label">Attendance Method</label>
                                                        <select name="attendance_method" class="form-control" required>
                                                            <option value="daily" {{ ($settings['attendance_method'] ?? 'daily') == 'daily' ? 'selected' : '' }}>
                                                                Daily Attendance</option>
                                                            <option value="session" {{ ($settings['attendance_method'] ?? 'daily') == 'session' ? 'selected' : '' }}>
                                                                Per Session</option>
                                                        </select>
                                                    </div>
    
                                                    <div class="settings-group">
                                                        <label class="settings-label">Late Arrival Threshold (minutes)</label>
                                                        <input type="number" name="late_threshold" class="form-control" value="{{ $settings['late_threshold'] ?? 15 }}" min="1" max="60">
                                                    </div>
    
                                                    <div class="settings-group">
                                                        <label class="settings-label">Send Absence Notifications</label>
                                                        <div class="toggle-switch">
                                                            <input type="checkbox" name="send_absence_notifications" id="send_absence_notifications" {{ ($settings['send_absence_notifications'] ?? true) ? 'checked' : '' }}>
                                                            <label for="send_absence_notifications">Enable notifications</label>
                                                        </div>
                                                    </div>                                                    <div class="settings-group">
                                                        <label class="settings-label">Notification Method</label>
                                                        <select name="absence_notification_method" class="form-control">
                                                            <option value="email" {{ ($settings['absence_notification_method'] ?? 'email') == 'email' ? 'selected' : '' }}>
                                                                Email</option>
                                                            <option value="sms" {{ ($settings['absence_notification_method'] ?? 'email') == 'sms' ? 'selected' : '' }}>
                                                                SMS</option>
                                                            <option value="both" {{ ($settings['absence_notification_method'] ?? 'email') == 'both' ? 'selected' : '' }}>
                                                                Both</option>
                                                        </select>
                                                    </div>
                                                    
                                                    <div class="settings-group">
                                                        <label class="settings-label">Enable Biometric Attendance</label>
                                                        <div class="toggle-switch">
                                                            <input type="checkbox" name="biometric_attendance" id="biometric_attendance" {{ ($settings['biometric_attendance'] ?? false) ? 'checked' : '' }}>
                                                            <label for="biometric_attendance">Enable biometric system integration</label>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="settings-group">
                                                        <label class="settings-label">Enable Mobile App Check-in</label>
                                                        <div class="toggle-switch">
                                                            <input type="checkbox" name="mobile_checkin" id="mobile_checkin" {{ ($settings['mobile_checkin'] ?? false) ? 'checked' : '' }}>
                                                            <label for="mobile_checkin">Allow check-in via mobile app</label>
                                                        </div>
                                                    </div>
                                                </div>
    
                                                <div class="text-right">
                                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                                </div>
                                            </form>
                                        </div>
                                        
                                        <!-- Fee Settings Tab -->
                                        <div class="tab-pane" id="fee">
                                            <form action="{{ route('schools.update-fee-settings') }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                
                                                <div class="settings-card">
                                                    <h4>Fee Configuration</h4>
                                                    
                                                    <div class="settings-group">
                                                        <label class="settings-label">Default Currency</label>
                                                        <select name="currency" class="form-control" required>
                                                            <option value="USD" {{ ($settings['currency'] ?? 'USD') == 'USD' ? 'selected' : '' }}>USD ($)</option>
                                                            <option value="EUR" {{ ($settings['currency'] ?? 'USD') == 'EUR' ? 'selected' : '' }}>EUR (€)</option>
                                                            <option value="GBP" {{ ($settings['currency'] ?? 'USD') == 'GBP' ? 'selected' : '' }}>GBP (£)</option>
                                                            <option value="INR" {{ ($settings['currency'] ?? 'USD') == 'INR' ? 'selected' : '' }}>INR (₹)</option>
                                                            <option value="AED" {{ ($settings['currency'] ?? 'USD') == 'AED' ? 'selected' : '' }}>AED (د.إ)</option>
                                                        </select>
                                                    </div>
                                                    
                                                    <div class="settings-group">
                                                        <label class="settings-label">Fee Payment Due Day</label>
                                                        <select name="fee_due_day" class="form-control" required>
                                                            @for($i = 1; $i <= 28; $i++)
                                                                <option value="{{ $i }}" {{ ($settings['fee_due_day'] ?? 1) == $i ? 'selected' : '' }}>
                                                                    {{ $i }}{{ $i == 1 ? 'st' : ($i == 2 ? 'nd' : ($i == 3 ? 'rd' : 'th')) }} of each month
                                                                </option>
                                                            @endfor
                                                        </select>
                                                    </div>
                                                    
                                                    <div class="settings-group">
                                                        <label class="settings-label">Late Fee Percentage</label>
                                                        <input type="number" name="late_fee_percentage" class="form-control" value="{{ $settings['late_fee_percentage'] ?? 5 }}" min="0" max="20" step="0.5">
                                                        <small class="text-muted">Percentage added to unpaid fees after due date</small>
                                                    </div>
                                                    
                                                    <div class="settings-group">
                                                        <label class="settings-label">Enable Online Payments</label>
                                                        <div class="toggle-switch">
                                                            <input type="checkbox" name="online_payments" id="online_payments" {{ ($settings['online_payments'] ?? false) ? 'checked' : '' }}>
                                                            <label for="online_payments">Allow online fee payments</label>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="settings-group" id="payment-gateways" style="{{ ($settings['online_payments'] ?? false) ? '' : 'display: none;' }}">
                                                        <label class="settings-label">Payment Gateways</label>
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="payment_gateways[]" value="stripe" {{ in_array('stripe', $settings['payment_gateways'] ?? []) ? 'checked' : '' }}>
                                                                        Stripe
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="payment_gateways[]" value="paypal" {{ in_array('paypal', $settings['payment_gateways'] ?? []) ? 'checked' : '' }}>
                                                                        PayPal
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="payment_gateways[]" value="razorpay" {{ in_array('razorpay', $settings['payment_gateways'] ?? []) ? 'checked' : '' }}>
                                                                        Razorpay
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="settings-group">
                                                        <label class="settings-label">Enable Partial Payments</label>
                                                        <div class="toggle-switch">
                                                            <input type="checkbox" name="partial_payments" id="partial_payments" {{ ($settings['partial_payments'] ?? false) ? 'checked' : '' }}>
                                                            <label for="partial_payments">Allow paying fees in installments</label>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="settings-group">
                                                        <label class="settings-label">Send Payment Reminders</label>
                                                        <div class="toggle-switch">
                                                            <input type="checkbox" name="payment_reminders" id="payment_reminders" {{ ($settings['payment_reminders'] ?? true) ? 'checked' : '' }}>
                                                            <label for="payment_reminders">Send automatic reminders</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="text-right">
                                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                                </div>
                                            </form>
                                        </div>
                                        
                                        <!-- Notifications Tab -->
                                        <div class="tab-pane" id="notifications">
                                            <form action="{{ route('schools.update-notification-settings') }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                
                                                <div class="settings-card">
                                                    <h4>Notification Preferences</h4>
                                                    
                                                    <div class="settings-group">
                                                        <label class="settings-label">Default Notification Method</label>
                                                        <select name="default_notification_method" class="form-control" required>
                                                            <option value="email" {{ ($settings['default_notification_method'] ?? 'email') == 'email' ? 'selected' : '' }}>Email</option>
                                                            <option value="sms" {{ ($settings['default_notification_method'] ?? 'email') == 'sms' ? 'selected' : '' }}>SMS</option>
                                                            <option value="push" {{ ($settings['default_notification_method'] ?? 'email') == 'push' ? 'selected' : '' }}>Push Notification</option>
                                                            <option value="both" {{ ($settings['default_notification_method'] ?? 'email') == 'both' ? 'selected' : '' }}>Email & SMS</option>
                                                        </select>
                                                    </div>
                                                    
                                                    <div class="settings-group">
                                                        <label class="settings-label">Notification Sender Email</label>
                                                        <input type="email" name="notification_email" class="form-control" value="{{ $settings['notification_email'] ?? 'noreply@school.edu' }}" required>
                                                    </div>
                                                    
                                                    <div class="settings-group">
                                                        <label class="settings-label">Notification Sender Name</label>
                                                        <input type="text" name="notification_sender_name" class="form-control" value="{{ $settings['notification_sender_name'] ?? $school->name }}" required>
                                                    </div>
                                                </div>
                                                
                                                <div class="settings-card">
                                                    <h4>Event Notifications</h4>
                                                    
                                                    <div class="settings-group">
                                                        <label class="settings-label">Upcoming Events</label>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="event_notifications[]" value="email" {{ in_array('email', $settings['event_notifications'] ?? ['email']) ? 'checked' : '' }}>
                                                                        Email
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="event_notifications[]" value="sms" {{ in_array('sms', $settings['event_notifications'] ?? []) ? 'checked' : '' }}>
                                                                        SMS
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="settings-group">
                                                        <label class="settings-label">Days Before Event</label>
                                                        <input type="number" name="event_notification_days" class="form-control" value="{{ $settings['event_notification_days'] ?? 1 }}" min="0" max="7">
                                                        <small class="text-muted">Send reminder this many days before event</small>
                                                    </div>
                                                </div>
                                                
                                                <div class="settings-card">
                                                    <h4>Academic Notifications</h4>
                                                    
                                                    <div class="settings-group">
                                                        <label class="settings-label">Exam Results</label>
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="exam_result_notifications[]" value="email" {{ in_array('email', $settings['exam_result_notifications'] ?? ['email']) ? 'checked' : '' }}>
                                                                        Email
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="exam_result_notifications[]" value="sms" {{ in_array('sms', $settings['exam_result_notifications'] ?? []) ? 'checked' : '' }}>
                                                                        SMS
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="exam_result_notifications[]" value="app" {{ in_array('app', $settings['exam_result_notifications'] ?? ['app']) ? 'checked' : '' }}>
                                                                        Mobile App
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="settings-group">
                                                        <label class="settings-label">Homework Assignments</label>
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="homework_notifications[]" value="email" {{ in_array('email', $settings['homework_notifications'] ?? ['email']) ? 'checked' : '' }}>
                                                                        Email
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="homework_notifications[]" value="sms" {{ in_array('sms', $settings['homework_notifications'] ?? []) ? 'checked' : '' }}>
                                                                        SMS
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="homework_notifications[]" value="app" {{ in_array('app', $settings['homework_notifications'] ?? ['app']) ? 'checked' : '' }}>
                                                                        Mobile App
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="text-right">
                                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                                </div>
                                            </form>
                                        </div>
                                        
                                        <!-- Security Tab -->
                                        <div class="tab-pane" id="security">
                                            <form action="{{ route('schools.update-security-settings') }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                
                                                <div class="settings-card">
                                                    <h4>Login Security</h4>
                                                    
                                                    <div class="settings-group">
                                                        <label class="settings-label">Enable Two-Factor Authentication</label>
                                                        <div class="toggle-switch">
                                                            <input type="checkbox" name="two_factor_auth" id="two_factor_auth" {{ ($settings['two_factor_auth'] ?? false) ? 'checked' : '' }}>
                                                            <label for="two_factor_auth">Require 2FA for all users</label>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="settings-group">
                                                        <label class="settings-label">Password Policy</label>
                                                        <select name="password_policy" class="form-control" required>
                                                            <option value="basic" {{ ($settings['password_policy'] ?? 'medium') == 'basic' ? 'selected' : '' }}>Basic (6+ characters)</option>
                                                            <option value="medium" {{ ($settings['password_policy'] ?? 'medium') == 'medium' ? 'selected' : '' }}>Medium (8+ chars with letters & numbers)</option>
                                                            <option value="strong" {{ ($settings['password_policy'] ?? 'medium') == 'strong' ? 'selected' : '' }}>Strong (10+ chars with mixed case, numbers & symbols)</option>
                                                        </select>
                                                    </div>
                                                    
                                                    <div class="settings-group">
                                                        <label class="settings-label">Password Expiration</label>
                                                        <select name="password_expiration" class="form-control" required>
                                                            <option value="0" {{ ($settings['password_expiration'] ?? 90) == 0 ? 'selected' : '' }}>Never expire</option>
                                                            <option value="30" {{ ($settings['password_expiration'] ?? 90) == 30 ? 'selected' : '' }}>Every 30 days</option>
                                                            <option value="60" {{ ($settings['password_expiration'] ?? 90) == 60 ? 'selected' : '' }}>Every 60 days</option>
                                                            <option value="90" {{ ($settings['password_expiration'] ?? 90) == 90 ? 'selected' : '' }}>Every 90 days</option>
                                                            <option value="180" {{ ($settings['password_expiration'] ?? 90) == 180 ? 'selected' : '' }}>Every 6 months</option>
                                                        </select>
                                                    </div>
                                                    
                                                    <div class="settings-group">
                                                        <label class="settings-label">Failed Login Attempts</label>
                                                        <input type="number" name="failed_login_attempts" class="form-control" value="{{ $settings['failed_login_attempts'] ?? 5 }}" min="1" max="10">
                                                        <small class="text-muted">Account lock after this many failed attempts</small>
                                                    </div>
                                                    
                                                    <div class="settings-group">
                                                        <label class="settings-label">Account Lockout Duration (minutes)</label>
                                                        <input type="number" name="lockout_duration" class="form-control" value="{{ $settings['lockout_duration'] ?? 30 }}" min="1" max="1440">
                                                    </div>
                                                </div>
                                                
                                                <div class="settings-card">
                                                    <h4>Session Management</h4>
                                                    
                                                    <div class="settings-group">
                                                        <label class="settings-label">Session Timeout</label>
                                                        <select name="session_timeout" class="form-control" required>
                                                            <option value="15" {{ ($settings['session_timeout'] ?? 30) == 15 ? 'selected' : '' }}>15 minutes</option>
                                                            <option value="30" {{ ($settings['session_timeout'] ?? 30) == 30 ? 'selected' : '' }}>30 minutes</option>
                                                            <option value="60" {{ ($settings['session_timeout'] ?? 30) == 60 ? 'selected' : '' }}>1 hour</option>
                                                            <option value="120" {{ ($settings['session_timeout'] ?? 30) == 120 ? 'selected' : '' }}>2 hours</option>
                                                            <option value="0" {{ ($settings['session_timeout'] ?? 30) == 0 ? 'selected' : '' }}>No timeout</option>
                                                        </select>
                                                    </div>
                                                    
                                                    <div class="settings-group">
                                                        <label class="settings-label">Allow Concurrent Logins</label>
                                                        <div class="toggle-switch">
                                                            <input type="checkbox" name="concurrent_logins" id="concurrent_logins" {{ ($settings['concurrent_logins'] ?? false) ? 'checked' : '' }}>
                                                            <label for="concurrent_logins">Allow multiple simultaneous sessions</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="settings-card">
                                                    <h4>Data Privacy</h4>
                                                    
                                                    <div class="settings-group">
                                                        <label class="settings-label">Enable GDPR Compliance</label>
                                                        <div class="toggle-switch">
                                                            <input type="checkbox" name="gdpr_compliance" id="gdpr_compliance" {{ ($settings['gdpr_compliance'] ?? false) ? 'checked' : '' }}>
                                                            <label for="gdpr_compliance">Enable GDPR features</label>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="settings-group">
                                                        <label class="settings-label">Data Retention Period (months)</label>
                                                        <input type="number" name="data_retention_period" class="form-control" value="{{ $settings['data_retention_period'] ?? 36 }}" min="6" max="120">
                                                        <small class="text-muted">How long to keep student records after graduation</small>
                                                    </div>
                                                    
                                                    <div class="settings-group">
                                                        <label class="settings-label">Enable Data Encryption</label>
                                                        <div class="toggle-switch">
                                                            <input type="checkbox" name="data_encryption" id="data_encryption" {{ ($settings['data_encryption'] ?? true) ? 'checked' : '' }}>
                                                            <label for="data_encryption">Encrypt sensitive data at rest</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="text-right">
                                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                                </div>
                                            </form>
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
    <!-- jquery ============================================ -->
    <script src="{{ asset('backend/js/vendor/jquery-1.12.4.min.js') }}"></script>
    <!-- bootstrap JS ============================================ -->
    <script src="{{ asset('backend/js/bootstrap.min.js') }}"></script>
    <!-- wow JS ============================================ -->
    <script src="{{ asset('backend/js/wow.min.js') }}"></script>
    <!-- price-slider JS ============================================ -->
    <script src="{{ asset('backend/js/jquery-price-slider.js') }}"></script>
    <!-- meanmenu JS ============================================ -->
    <script src="{{ asset('backend/js/jquery.meanmenu.js') }}"></script>
    <!-- owl.carousel JS ============================================ -->
    <script src="{{ asset('backend/js/owl.carousel.min.js') }}"></script>
    <!-- sticky JS ============================================ -->
    <script src="{{ asset('backend/js/jquery.sticky.js') }}"></script>
    <!-- scrollUp JS ============================================ -->
    <script src="{{ asset('backend/js/jquery.scrollUp.min.js') }}"></script>
    <!-- mCustomScrollbar JS ============================================ -->
    <script src="{{ asset('backend/js/scrollbar/jquery.mCustomScrollbar.concat.min.js') }}"></script>
    <script src="{{ asset('backend/js/scrollbar/mCustomScrollbar-active.js') }}"></script>
    <!-- metisMenu JS ============================================ -->
    <script src="{{ asset('backend/js/metisMenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('backend/js/metisMenu/metisMenu-active.js') }}"></script>
    <!-- data table JS ============================================ -->
    <script src="{{ asset('backend/js/data-table/bootstrap-table.js') }}"></script>
    <script src="{{ asset('backend/js/data-table/tableExport.js') }}"></script>
    <script src="{{ asset('backend/js/data-table/data-table-active.js') }}"></script>
    <script src="{{ asset('backend/js/data-table/bootstrap-table-editable.js') }}"></script>
    <script src="{{ asset('backend/js/data-table/bootstrap-editable.js') }}"></script>
    <script src="{{ asset('backend/js/data-table/bootstrap-table-resizable.js') }}"></script>
    <script src="{{ asset('backend/js/data-table/colResizable-1.5.source.js') }}"></script>
    <script src="{{ asset('backend/js/data-table/bootstrap-table-export.js') }}"></script>
    <!--  editable JS ============================================ -->
    <script src="{{ asset('backend/js/editable/jquery.mockjax.js') }}"></script>
    <script src="{{ asset('backend/js/editable/mock-active.js') }}"></script>
    <script src="{{ asset('backend/js/editable/select2.js') }}"></script>
    <script src="{{ asset('backend/js/editable/moment.min.js') }}"></script>
    <script src="{{ asset('backend/js/editable/bootstrap-datetimepicker.js') }}"></script>
    <script src="{{ asset('backend/js/editable/bootstrap-editable.js') }}"></script>
    <script src="{{ asset('backend/js/editable/xediable-active.js') }}"></script>
    <!-- Chart JS ============================================ -->
    <script src="{{ asset('backend/js/chart/jquery.peity.min.js') }}"></script>
    <script src="{{ asset('backend/js/peity/peity-active.js') }}"></script>
    <!-- tab JS ============================================ -->
    <script src="{{ asset('backend/js/tab.js') }}"></script>
    <!-- plugins JS ============================================ -->
    <script src="{{ asset('backend/js/plugins.js') }}"></script>
    <!-- main JS ============================================ -->
    <script src="{{ asset('backend/js/main.js') }}"></script>
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

    <script>
        $(document).ready(function () {
            // Initialize left tabs
            $('.settings-menu .nav-tabs a').click(function (e) {
                e.preventDefault();
                $(this).tab('show');
            });

            // Initialize toggle switches
            $('.toggle-switch input[type="checkbox"]').bootstrapToggle({
                on: 'Enabled',
                off: 'Disabled'
            });
            
            // Show/hide payment gateways based on online payments toggle
            $('#online_payments').change(function() {
                if($(this).prop('checked')) {
                    $('#payment-gateways').show();
                } else {
                    $('#payment-gateways').hide();
                }
            });
            
            // Activate the tab from URL hash if present
            if(window.location.hash) {
                $('.settings-menu .nav-tabs a[href="' + window.location.hash + '"]').tab('show');
            }
            
            // Update URL hash when tab changes
            $('.settings-menu .nav-tabs a').on('shown.bs.tab', function(e) {
                window.location.hash = e.target.hash;
            });
            
            // Initialize select2 for better select boxes
            $('select.form-control').select2({
                minimumResultsForSearch: Infinity,
                width: '100%'
            });
        });
    </script>
    @endpush
</x-tenant-app-layout>