{{-- <x-tenant-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-tenant-app-layout> --}}
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

                                        {{-- 
                                        #attributes: array:17 [▼
                                        "id" => 1
                                        "school_id" => null
                                        "name" => "ameen"
                                        "email" => "ameen@gmail.com"
                                        "profile_pic" => "tenants/1da76068-cadc-45b4-a7f0-6ec51fa37822/teachers/profile_pics/Hp4VlppDnTPr3zSXM13yRvXeg7kvCZgcieYjmEpS.jpg"
                                        "email_verified_at" => null
                                        "password" => "$2y$12$VmX4j.sD2ojClWhlw921yuMUvygA2a4ZXS6Lo0tkvNiTqDw1EMySW"
                                        "phone" => null
                                        "address" => null
                                        "gender" => null
                                        "dob" => null
                                        "remember_token" => "7PVz31k9mR07cjpSsVny68E97hMNbXDIwsvR8XvDz4ZaXQYSp4nhlTH0gYbm"
                                        "role" => "admin"
                                        "deleted_at" => null
                                        "created_at" => "2025-04-26 09:53:51"
                                        "updated_at" => "2025-04-26 09:53:51"
                                        "status" => "active"
                                      ] --}}
                                        <form id="teacherForm" method="POST" action="{{ route('profile.update',$user->id) }}" enctype="multipart/form-data">
                                            @csrf

                                            @method('Patch')
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
                                                                @if($user->profile_pic)
                                                                    <img src="{{ asset($user->profile_pic) }}" style="max-height: 100px; margin-bottom: 10px;">
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
                                                                <input type="text" class="form-control" name="name" value="{{ old('name', $user->name) }}" required />
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
                                                                <input type="email" class="form-control" name="email" value="{{ old('email', $user->email) }}" required />
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
                                                                <input type="text" class="form-control" name="phone" value="{{ old('phone', $user->phone) }}" required />
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
                                                                <textarea class="form-control" name="address" required>{{ old('address', $user->address) }}</textarea>
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
                                                                    <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                                                    <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                                                    <option value="other" {{ old('gender', $user->gender) == 'other' ? 'selected' : '' }}>Other</option>
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
                                                                                <input type="text" name="dob" readonly class="form-control" value="{{ old('dob', $user->dob) }}" required>
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

                                                    <div class="form-group-inner">
                                                        <div class="row">
                                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                                <label class="login2">Select Role*</label>
                                                            </div>
                                                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                                <select name="roles[]" data-placeholder="Choose a Country..." class="chosen-select" multiple="" tabindex="-1">
                                                                    <option value="">Select Role</option>
                                                                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                                                                    <option value="teacher" {{ old('role', $user->role) == 'teacher' ? 'selected' : '' }}>Teacher</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="form-group-inner @error('current_password') has-error @enderror">
                                                        <div class="row">
                                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                                <label class="login2">Current Password</label>
                                                            </div>
                                                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                                <input type="password" class="form-control" name="current_password" ></input>
                                                                @error('current_password')
                                                                    <span class="help-block text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group-inner @error('password') has-error @enderror">
                                                        <div class="row">
                                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                                <label class="login2">New Password</label>
                                                            </div>
                                                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                                <input type="password" class="form-control" name="password" ></input>
                                                                @error('password')
                                                                    <span class="help-block text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group-inner">
                                                        <div class="row">
                                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                                <label class="login2">Confirmation Password</label>
                                                            </div>
                                                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                                <input type="password" class="form-control" name="password_confirmation" ></input>
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
                                                                    <button class="btn btn-sm btn-primary login-submit-cs" type="submit">Update Profile</button>
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