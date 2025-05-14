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
        <!-- Advanced Form Start -->
        <div class="advanced-form-area mg-b-15">
           
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="breadcome-list">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <div class="breadcome-heading" style="margin-top: 10px">
                                        <h3>Teacher Registration Form</h3>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <ul class="breadcome-menu">
                                        <li>
                                            <a href="{{ route('dashboard.teachers') }}"
                                                class="btn btn-primary btn-sm" style="color: white">
                                                <i class="fa fa-arrow-left"></i> Back
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="sparkline12-list">
                            <div class="sparkline12-graph">
                                <div class="basic-login-form-ad">
                                    <div class="row">
                                        <form id="teacherForm" method="POST" action="{{ route('admin.store.teacher') }}" enctype="multipart/form-data">
                                            @csrf

                                            <!-- Personal Information Section -->
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div class="all-form-element-inner">
                                                    <div class="section-headline">
                                                        <h3>Personal Information</h3>
                                                    </div>

                                                    <div class="form-group-inner {{ $errors->has('profile_pic') ? 'has-error' : '' }}">
                                                        <div class="row">
                                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                                <label class="login2">Profile Image</label>
                                                            </div>
                                                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                                <input type="file" class="form-control" name="profile_pic" />
                                                                @if($errors->has('profile_pic'))
                                                                    <span class="help-block text-danger">{{ $errors->first('profile_pic') }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group-inner {{ $errors->has('name') ? 'has-error' : '' }}">
                                                        <div class="row">
                                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                                <label class="login2">Full Name*</label>
                                                            </div>
                                                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                                <input type="text" class="form-control" name="name" value="{{ old('name') }}" required />
                                                                @if($errors->has('name'))
                                                                    <span class="help-block text-danger">{{ $errors->first('name') }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group-inner {{ $errors->has('email') ? 'has-error' : '' }}">
                                                        <div class="row">
                                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                                <label class="login2">Email*</label>
                                                            </div>
                                                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                                <input type="email" class="form-control" name="email" value="{{ old('email') }}" required />
                                                                @if($errors->has('email'))
                                                                    <span class="help-block text-danger">{{ $errors->first('email') }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group-inner {{ $errors->has('phone') ? 'has-error' : '' }}">
                                                        <div class="row">
                                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                                <label class="login2">Phone Number*</label>
                                                            </div>
                                                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                                <input type="text" class="form-control" name="phone" value="{{ old('phone') }}" required />
                                                                @if($errors->has('phone'))
                                                                    <span class="help-block text-danger">{{ $errors->first('phone') }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group-inner {{ $errors->has('address') ? 'has-error' : '' }}">
                                                        <div class="row">
                                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                                <label class="login2">Address*</label>
                                                            </div>
                                                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                                <textarea class="form-control" name="address" required>{{ old('address') }}</textarea>
                                                                @if($errors->has('address'))
                                                                    <span class="help-block text-danger">{{ $errors->first('address') }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group-inner {{ $errors->has('gender') ? 'has-error' : '' }}">
                                                        <div class="row">
                                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                                <label class="login2">Gender*</label>
                                                            </div>
                                                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                                <select class="form-control" name="gender" required>
                                                                    <option value="">Select Gender</option>
                                                                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                                                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                                                    <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                                                                </select>
                                                                @if($errors->has('gender'))
                                                                    <span class="help-block text-danger">{{ $errors->first('gender') }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group-inner">
                                                        <div class="row">
                                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                                <label class="login2">Date of birth*</label>
                                                            </div>
                                                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                                <div class="sparkline16-graph">
                                                                    <div class="date-picker-inner">
                                                                        <div class="form-group data-custon-pick" id="data_1">
                                                                            <div class="input-group date">
                                                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                                                <input type="text" name="dob" readonly class="form-control @error('dob') is-invalid @enderror" value="{{ old('dob') }}" required>
        
                                                                            </div>
                                                                            @error('dob') <small class="text-danger">{{ $message }}</small> @enderror
        
                                                                        </div>
                                                                    </div>
                                                                </div>                                               
                                                            </div>
                                                        </div>
                                                    </div>
                                                   
                                                    <div class="form-group-inner">
                                                        <div class="row">
                                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                                <label class="login2">Select Role*</label>
                                                            </div>
                                                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                                <select name="roles[]" data-placeholder="Choose a Country..." class="chosen-select" multiple="" tabindex="-1">
                                                                    <option value="">Select Role</option>
                                                                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                                                    <option value="teacher" {{ old('role') == 'teacher' ? 'selected' : '' }}>Teacher</option>
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
                                                    <div class="form-group-inner {{ $errors->has('employee_id') ? 'has-error' : '' }}">
                                                        <div class="row">
                                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                                <label class="login2">Employee ID*</label>
                                                            </div>
                                                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                                <input type="text" class="form-control" name="employee_id" value="{{ old('employee_id') }}" required />
                                                                @if($errors->has('employee_id'))
                                                                    <span class="help-block text-danger">{{ $errors->first('employee_id') }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group-inner {{ $errors->has('qualification') ? 'has-error' : '' }}">
                                                        <div class="row">
                                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                                <label class="login2">Qualification*</label>
                                                            </div>
                                                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                                <input type="text" class="form-control" name="qualification" value="{{ old('qualification') }}" required />
                                                                @if($errors->has('qualification'))
                                                                    <span class="help-block text-danger">{{ $errors->first('qualification') }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group-inner {{ $errors->has('specialization') ? 'has-error' : '' }}">
                                                        <div class="row">
                                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                                <label class="login2">Specialization*</label>
                                                            </div>
                                                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                                <input type="text" class="form-control" name="specialization" value="{{ old('specialization') }}" required />
                                                                @if($errors->has('specialization'))
                                                                    <span class="help-block text-danger">{{ $errors->first('specialization') }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group-inner {{ $errors->has('experience_years') ? 'has-error' : '' }}">
                                                        <div class="row">
                                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                                <label class="login2">Years of Experience*</label>
                                                            </div>
                                                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                                <input type="number" class="form-control" name="experience_years" value="{{ old('experience_years') }}" required />
                                                                @if($errors->has('experience_years'))
                                                                    <span class="help-block text-danger">{{ $errors->first('experience_years') }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group-inner">
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
                                                                                <input type="text" name="joining_date" readonly class="form-control @error('joining_date') is-invalid @enderror" value="{{ old('joining_date') }}" required>
        
                                                                            </div>
                                                                            @error('joining_date') <small class="text-danger">{{ $message }}</small> @enderror
        
                                                                        </div>
                                                                    </div>
                                                                </div>                                               
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group-inner {{ $errors->has('salary_grade') ? 'has-error' : '' }}">
                                                        <div class="row">
                                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                                <label class="login2">Salary Grade</label>
                                                            </div>
                                                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                                <input type="text" class="form-control" name="salary_grade" value="{{ old('salary_grade') }}" />
                                                                @if($errors->has('salary_grade'))
                                                                    <span class="help-block text-danger">{{ $errors->first('salary_grade') }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group-inner {{ $errors->has('bank_details') ? 'has-error' : '' }}">
                                                        <div class="row">
                                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                                <label class="login2">Bank Details</label>
                                                            </div>
                                                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                                <textarea class="form-control" name="bank_details">{{ old('bank_details') }}</textarea>
                                                                @if($errors->has('bank_details'))
                                                                    <span class="help-block text-danger">{{ $errors->first('bank_details') }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group-inner {{ $errors->has('emergency_contact') ? 'has-error' : '' }}">
                                                        <div class="row">
                                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                                <label class="login2">Emergency Contact*</label>
                                                            </div>
                                                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                                <input type="text" class="form-control" name="emergency_contact" value="{{ old('emergency_contact') }}" required />
                                                                @if($errors->has('emergency_contact'))
                                                                    <span class="help-block text-danger">{{ $errors->first('emergency_contact') }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group-inner {{ $errors->has('bio') ? 'has-error' : '' }}">
                                                        <div class="row">
                                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                                <label class="login2">Bio</label>
                                                            </div>
                                                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                                <textarea class="form-control" name="bio">{{ old('bio') }}</textarea>
                                                                @if($errors->has('bio'))
                                                                    <span class="help-block text-danger">{{ $errors->first('bio') }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group-inner {{ $errors->has('social_links') ? 'has-error' : '' }}">
                                                        <div class="row">
                                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                                <label class="login2">Social Links</label>
                                                            </div>
                                                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                                <input type="text" class="form-control" name="social_links" value="{{ old('social_links') }}" placeholder="Comma separated links (e.g., facebook.com, twitter.com)" />
                                                                @if($errors->has('social_links'))
                                                                    <span class="help-block text-danger">{{ $errors->first('social_links') }}</span>
                                                                @endif
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
                                                                    <input type="checkbox" name="is_class_teacher" value="1" id="isClassTeacher" {{ old('is_class_teacher') ? 'checked' : '' }}>
                                                                    <span class="checkmark"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group-inner {{ $errors->has('class_teacher_of') ? 'has-error' : '' }}" id="classTeacherOfContainer" style="display:{{ old('is_class_teacher') ? 'block' : 'none' }};">
                                                        <div class="row">
                                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                                <label class="login2">Class Teacher Of</label>
                                                            </div>
                                                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                                <select class="form-control select2_demo_3" name="class_teacher_of">
                                                                    <option value="">Select Class</option>
                                                                    <option value="1" {{ old('class_teacher_of') == '1' ? 'selected' : '' }}>Class 1</option>
                                                                    <option value="2" {{ old('class_teacher_of') == '2' ? 'selected' : '' }}>Class 2</option>
                                                                    <option value="3" {{ old('class_teacher_of') == '3' ? 'selected' : '' }}>Class 3</option>
                                                                </select>
                                                                @if($errors->has('class_teacher_of'))
                                                                    <span class="help-block text-danger">{{ $errors->first('class_teacher_of') }}</span>
                                                                @endif
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
                                                    <div class="form-group-inner {{ $errors->has('qualification_documents') ? 'has-error' : '' }}">
                                                        <div class="row">
                                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                                <label class="login2">Qualifications Documents*</label>
                                                            </div>
                                                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                                <input type="file" class="form-control" name="qualification_documents" required />
                                                                @if($errors->has('qualification_documents'))
                                                                    <span class="help-block text-danger">{{ $errors->first('qualification_documents') }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group-inner {{ $errors->has('signature') ? 'has-error' : '' }}">
                                                        <div class="row">
                                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                                <label class="login2">Signature</label>
                                                            </div>
                                                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                                <input type="file" class="form-control" name="signature" />
                                                                @if($errors->has('signature'))
                                                                    <span class="help-block text-danger">{{ $errors->first('signature') }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group-inner {{ $errors->has('documents') ? 'has-error' : '' }}">
                                                        <div class="row">
                                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                                <label class="login2">Other Documents</label>
                                                            </div>
                                                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                                <input type="file" class="form-control" name="documents[]" multiple />
                                                                @if($errors->has('documents'))
                                                                    <span class="help-block text-danger">{{ $errors->first('documents') }}</span>
                                                                @endif
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
                                                                    <button class="btn btn-sm btn-primary login-submit-cs" type="submit">Register Teacher</button>
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
            <!-- Advanced Form End-->
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

            {{-- <script>
                // Show/hide class teacher field based on checkbox
                document.getElementById('isClassTeacher').addEventListener('change', function() {
                    const container = document.getElementById('classTeacherOfContainer');
                    container.style.display = this.checked ? 'block' : 'none';
                });
            </script> --}}
        
        @endpush
</x-tenant-app-layout>