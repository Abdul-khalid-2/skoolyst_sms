<x-tenant-app-layout>
    @push('css')
        {{-- ============================================ --> --}}
        <link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico">
        <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,700,900" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('backend/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/font-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/owl.carousel.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/owl.theme.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/owl.transitions.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/animate.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/normalize.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/meanmenu.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/main.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/educate-custon-icon.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/morrisjs/morris.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/scrollbar/jquery.mCustomScrollbar.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/metisMenu/metisMenu.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/metisMenu/metisMenu-vertical.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/calendar/fullcalendar.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/calendar/fullcalendar.print.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/touchspin/jquery.bootstrap-touchspin.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/datapicker/datepicker3.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/form/themesaller-forms.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/colorpicker/colorpicker.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/select2/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/chosen/bootstrap-chosen.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/ionRangeSlider/ion.rangeSlider.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/ionRangeSlider/ion.rangeSlider.skinFlat.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/style.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/responsive.css') }}">
        <script src="{{ asset('backend/js/vendor/modernizr-2.8.3.min.js') }}"></script>

    @endpush
    <x-slot name="header"></x-slot>
    
    <div class="advanced-form-area mg-b-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="breadcome-list">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="breadcome-heading" style="margin-top: 10px">
                                    <h3>Update Teacher Information</h3>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="action-buttons">
                                    <a href="{{ route('dashboard.teachers') }}" class="btn btn-primary btn-sm" style="color: white">
                                            <i class="fa fa-arrow-left"></i> Back
                                        </a>
                                </div>
                                <div class="dropdown-container">
                                    <button class="dropdown-toggle-custom">
                                        <i class="fa fa-ellipsis-v"></i>
                                    </button>
                                    <div class="dropdown-menu-custom">
                                        <a href="{{ route('dashboard.teachers') }}" class="btn btn-primary btn-sm" style="color: white">
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
                        <div class="sparkline12-graph">
                            <div class="basic-login-form-ad">
                                <div class="row">
                                    @if($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    <form id="teacherForm" method="POST" action="{{ route("admin.update.teacher", $teacher->id) }}" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')

                                        <!-- Personal Information Section -->
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="all-form-element-inner">
                                                <div class="section-headline">
                                                    <h3>Personal Information</h3>
                                                </div>


                                                <div class="form-group-inner">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <label class="login2">Current Profile</label>
                                                        </div>
                                                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                            @if($teacher->profile_pic)
                                                                <img src="{{ asset('tenancy/assets/'. $teacher->profile_pic) }}" style="max-height: 100px; margin-bottom: 10px;">
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="form-group-inner ">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <label class="login2">Profile Image</label>
                                                        </div>
                                                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                            <input type="file" class="form-control" name="profile_pic">
                                                                                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group-inner @error('name') has-error @enderror">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <label class="login2">Full Name*</label>
                                                        </div>
                                                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                            <input type="text" class="form-control" name="name" value="{{ old('name', $teacher->name) }}" required />
                                                            @error('name')
                                                                <span class="help-block text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group-inner @error('email') has-error @enderror">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <label class="login2">Email*</label>
                                                        </div>
                                                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                            <input type="email" class="form-control" name="email" value="{{ old('email', $teacher->email) }}" required />
                                                            @error('email')
                                                                <span class="help-block text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group-inner @error('phone') has-error @enderror">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <label class="login2">Phone Number*</label>
                                                        </div>
                                                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                            <input type="text" class="form-control" name="phone" value="{{ old('phone', $teacher->phone) }}" required />
                                                            @error('phone')
                                                                <span class="help-block text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group-inner @error('address') has-error @enderror">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <label class="login2">Address*</label>
                                                        </div>
                                                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                            <textarea class="form-control" name="address" required>{{ old('address', $teacher->address) }}</textarea>
                                                            @error('address')
                                                                <span class="help-block text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group-inner @error('gender') has-error @enderror">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <label class="login2">Gender*</label>
                                                        </div>
                                                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                            <select class="form-control" name="gender" required>
                                                                <option value="">Select Gender</option>
                                                                <option value="male" {{ old('gender', $teacher->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                                                <option value="female" {{ old('gender', $teacher->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                                                <option value="other" {{ old('gender', $teacher->gender) == 'other' ? 'selected' : '' }}>Other</option>
                                                            </select>
                                                            @error('gender')
                                                                <span class="help-block text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group-inner @error('dob') has-error @enderror">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <label class="login2">Date of Birth*</label>
                                                        </div>
                                                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                            <div class="sparkline16-graph">
                                                                <div class="date-picker-inner">
                                                                    <div class="form-group data-custon-pick" id="data_1">
                                                                        <div class="input-group date">
                                                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                                            <input type="text" name="dob" readonly class="form-control" value="{{ old('dob', $teacher->dob) }}" required>
                                                                        </div>
                                                                        @error('dob')
                                                                            <small class="text-danger">{{ $message }}</small>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                            </div>                                               
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- <div class="form-group-inner @error('role') has-error @enderror">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <label class="login2">Role*</label>
                                                        </div>
                                                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                            <select name="role" class="form-control" required>
                                                                <option value="">Select Role</option>
                                                                <option value="admin" {{ old('role', $teacher->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                                                                <option value="teacher" {{ old('role', $teacher->role) == 'teacher' ? 'selected' : '' }}>Teacher</option>
                                                            </select>
                                                            @error('role')
                                                                <span class="help-block text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div> --}}

                                                <div class="form-group-inner">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <label class="login2">Select Role*</label>
                                                        </div>
                                                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                            <select name="roles[]" data-placeholder="Choose a Country..." class="chosen-select" multiple="" tabindex="-1">
                                                                <option value="">Select Role</option>
                                                                <option value="admin" {{ old('role', $teacher->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                                                                <option value="teacher" {{ old('role', $teacher->role) == 'teacher' ? 'selected' : '' }}>Teacher</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Professional Information Section -->
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="all-form-element-inner">
                                                <div class="section-headline">
                                                    <h3>Professional Information</h3>
                                                </div>

                                                <div class="form-group-inner @error('employee_id') has-error @enderror">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <label class="login2">Employee ID*</label>
                                                        </div>
                                                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                            <input type="text" class="form-control" name="employee_id" value="{{ old('employee_id', $teacher->teacherProfile->employee_id) }}" required />
                                                            @error('employee_id')
                                                                <span class="help-block text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group-inner @error('qualification') has-error @enderror">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <label class="login2">Qualification*</label>
                                                        </div>
                                                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                            <input type="text" class="form-control" name="qualification" value="{{ old('qualification', $teacher->teacherProfile->qualification) }}" required />
                                                            @error('qualification')
                                                                <span class="help-block text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group-inner @error('specialization') has-error @enderror">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <label class="login2">Specialization*</label>
                                                        </div>
                                                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                            <input type="text" class="form-control" name="specialization" value="{{ old('specialization', $teacher->teacherProfile->specialization) }}" required />
                                                            @error('specialization')
                                                                <span class="help-block text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group-inner @error('experience_years') has-error @enderror">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <label class="login2">Years of Experience*</label>
                                                        </div>
                                                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                            <input type="number" class="form-control" name="experience_years" value="{{ old('experience_years', $teacher->teacherProfile->experience_years) }}" required />
                                                            @error('experience_years')
                                                                <span class="help-block text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group-inner @error('joining_date') has-error @enderror">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <label class="login2">Joining Date*</label>
                                                        </div>
                                                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                            <div class="sparkline16-graph">
                                                                <div class="date-picker-inner">
                                                                    <div class="form-group data-custon-pick" id="data_1">
                                                                        <div class="input-group date">
                                                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                                            <input type="text" name="joining_date" readonly class="form-control" value="{{ old('joining_date', $teacher->teacherProfile->joining_date) }}" required>
                                                                        </div>
                                                                        @error('joining_date')
                                                                            <small class="text-danger">{{ $message }}</small>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                            </div>                                               
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Salary Fields -->
                                                <div class="form-group-inner @error('base_salary') has-error @enderror">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <label class="login2">Base Salary</label>
                                                        </div>
                                                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                            <input type="number" step="0.01" class="form-control" name="base_salary" value="{{ old('base_salary', $teacher->teacherProfile->base_salary) }}" />
                                                            @error('base_salary')
                                                                <span class="help-block text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group-inner @error('current_salary') has-error @enderror">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <label class="login2">Current Salary</label>
                                                        </div>
                                                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                            <input type="number" step="0.01" class="form-control" name="current_salary" value="{{ old('current_salary', $teacher->teacherProfile->current_salary) }}" />
                                                            @error('current_salary')
                                                                <span class="help-block text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group-inner @error('last_increment_date') has-error @enderror">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <label class="login2">Last Increment Date</label>
                                                        </div>
                                                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                            <div class="sparkline16-graph">
                                                                <div class="date-picker-inner">
                                                                    <div class="form-group data-custon-pick" id="data_1">
                                                                        <div class="input-group date">
                                                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                                            <input type="text" name="last_increment_date" readonly class="form-control" value="{{ old('last_increment_date', $teacher->teacherProfile->last_increment_date) }}">
                                                                        </div>
                                                                        @error('last_increment_date')
                                                                            <small class="text-danger">{{ $message }}</small>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                            </div>                                               
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group-inner @error('salary_grade') has-error @enderror">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <label class="login2">Salary Grade</label>
                                                        </div>
                                                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                            <input type="text" class="form-control" name="salary_grade" value="{{ old('salary_grade', $teacher->teacherProfile->salary_grade) }}" />
                                                            @error('salary_grade')
                                                                <span class="help-block text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group-inner @error('bank_details') has-error @enderror">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <label class="login2">Bank Details</label>
                                                        </div>
                                                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                            <textarea class="form-control" name="bank_details">{{ old('bank_details', $teacher->teacherProfile->bank_details) }}</textarea>
                                                            @error('bank_details')
                                                                <span class="help-block text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group-inner @error('emergency_contact') has-error @enderror">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <label class="login2">Emergency Contact*</label>
                                                        </div>
                                                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                            <input type="text" class="form-control" name="emergency_contact" value="{{ old('emergency_contact', $teacher->teacherProfile->emergency_contact) }}" required />
                                                            @error('emergency_contact')
                                                                <span class="help-block text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group-inner @error('bio') has-error @enderror">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <label class="login2">Bio</label>
                                                        </div>
                                                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                            <textarea class="form-control" name="bio">{{ old('bio', $teacher->teacherProfile->bio) }}</textarea>
                                                            @error('bio')
                                                                <span class="help-block text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group-inner @error('social_links') has-error @enderror">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <label class="login2">Social Links</label>
                                                        </div>
                                                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                            <input type="text" class="form-control" name="social_links" value="{{ old('social_links', $teacher->teacherProfile->social_links) }}" placeholder="Comma separated links" />
                                                            @error('social_links')
                                                                <span class="help-block text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group-inner">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <label class="login2">Is Class Teacher</label>
                                                        </div>
                                                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                            <div class="bt-df-checkbox">
                                                                <input type="checkbox" name="is_class_teacher" value="1" id="isClassTeacher" {{ old('is_class_teacher', $teacher->teacherProfile->is_class_teacher) ? 'checked' : '' }}>
                                                                <span class="checkmark"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group-inner @error('class_teacher_of') has-error @enderror" id="classTeacherOfContainer" style="display: {{ old('is_class_teacher', $teacher->teacherProfile->is_class_teacher) ? 'block' : 'none' }};">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <label class="login2">Class Teacher Of</label>
                                                        </div>
                                                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                            <select class="form-control select2_demo_3" name="class_teacher_of">
                                                                <option value="">Select Class</option>
                                                                @foreach($classes as $class)
                                                                    <option value="{{ $class->id }}" {{ old('class_teacher_of', $teacher->teacherProfile->class_teacher_of) == $class->id ? 'selected' : '' }}>
                                                                        {{ $class->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            @error('class_teacher_of')
                                                                <span class="help-block text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Documents Section -->
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="all-form-element-inner">
                                                <div class="section-headline">
                                                    <h3>Documents</h3>
                                                </div>

                                                <div class="form-group-inner">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <label class="login2">Current Signature</label>
                                                        </div>
                                                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                            @if($teacher->teacherProfile->signature)
                                                                <img src="{{ asset('tenancy/assets/'. $teacher->teacherProfile->signature) }}" style="max-height: 100px; margin-bottom: 10px;">
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group-inner @error('signature') has-error @enderror">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <label class="login2">Update Signature</label>
                                                        </div>
                                                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                            <input type="file" class="form-control" name="signature" />
                                                            @error('signature')
                                                                <span class="help-block text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group-inner @error('documents') has-error @enderror">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <label class="login2">Additional Documents</label>
                                                        </div>
                                                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                            <input type="file" class="form-control" name="documents[]" multiple />
                                                            @error('documents')
                                                                <span class="help-block text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Submit Button -->
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group-inner">
                                                <div class="login-btn-inner">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"></div>
                                                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                            <div class="login-horizental">
                                                                <button class="btn btn-sm btn-primary login-submit-cs" type="submit">Update Teacher</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
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


    
    @endpush
 
        @push('js')
             <script>
                // Show/hide class teacher field based on checkbox
                $('#isClassTeacher').change(function() {
                    if(this.checked) {
                        $('#classTeacherOfContainer').show();
                    } else {
                        $('#classTeacherOfContainer').hide();
                    }
                });
                
                // You might want to add salary calculation logic here
                // For example, automatically update current salary when base salary changes
                $('input[name="base_salary"]').on('change', function() {
                    let baseSalary = $(this).val();
                    if(baseSalary && !$('input[name="current_salary"]').val()) {
                        $('input[name="current_salary"]').val(baseSalary);
                    }
                });
            </script>
        @endpush
</x-tenant-app-layout>