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
            .invalid-feedback {
                color: #dc3545;
                font-size: 0.875rem;
                margin-top: 0.25rem;
            }

            .is-invalid {
                border-color: #dc3545 !important;
            }

            .chosen-container.is-invalid .chosen-single {
                border-color: #dc3545 !important;
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
                                <h3>Parent Registration Form</h3>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <ul class="breadcome-menu">
                                <li>
                                    <a href="{{ route('dashboard.parents') }}" class="btn btn-primary btn-sm" style="color: white">
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
                                <form id="parentForm" method="POST" action="{{ route('admin.store.parent') }}" enctype="multipart/form-data">
                                    @csrf
                                    
                                    <!-- Personal Information Section -->
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="all-form-element-inner">
                                            <div class="section-headline">
                                                <h3>Personal Information</h3>
                                            </div>
                                            <div class="form-group-inner">
                                                <div class="row">
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                        <label class="login2">Full Name*</label>
                                                    </div>
                                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                                               name="name" value="{{ old('name') }}"  />
                                                        @error('name')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group-inner">
                                                <div class="row">
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                        <label class="login2">Email*</label>
                                                    </div>
                                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                                               name="email" value="{{ old('email') }}"  />
                                                        @error('email')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group-inner">
                                                <div class="row">
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                        <label class="login2">Phone Number*</label>
                                                    </div>
                                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                        <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                                               name="phone" value="{{ old('phone') }}"  />
                                                        @error('phone')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group-inner">
                                                <div class="row">
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                        <label class="login2">Address*</label>
                                                    </div>
                                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                        <textarea class="form-control @error('address') is-invalid @enderror" 
                                                                  name="address" >{{ old('address') }}</textarea>
                                                        @error('address')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group-inner">
                                                <div class="row">
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                        <label class="login2">Gender*</label>
                                                    </div>
                                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                        <select class="form-control @error('gender') is-invalid @enderror" name="gender" >
                                                            <option value="">Select Gender</option>
                                                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                                            <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                                                        </select>
                                                        @error('gender')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
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
                                                                        <input type="text" name="dob" readonly 
                                                                               class="form-control @error('dob') is-invalid @enderror" 
                                                                               value="{{ old('dob') }}" >
                                                                    </div>
                                                                    @error('dob')
                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>                                               
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Family Information Section -->
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="all-form-element-inner">
                                            <div class="section-headline">
                                                <h3>Family Information</h3>
                                            </div>
                                            <div class="form-group-inner">
                                                <div class="row">
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                        <label class="login2">Occupation*</label>
                                                    </div>
                                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                        <input type="text" class="form-control @error('occupation') is-invalid @enderror" 
                                                               name="occupation" value="{{ old('occupation') }}"  />
                                                        @error('occupation')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group-inner">
                                                <div class="row">
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                        <label class="login2">Employer</label>
                                                    </div>
                                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                        <input type="text" class="form-control @error('employer') is-invalid @enderror" 
                                                               name="employer" value="{{ old('employer') }}" />
                                                        @error('employer')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group-inner">
                                                <div class="row">
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                        <label class="login2">Income Range</label>
                                                    </div>
                                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                        <select class="form-control @error('income_range') is-invalid @enderror" name="income_range">
                                                            <option value="">Select Income Range</option>
                                                            <option value="0-25000" {{ old('income_range') == '0-25000' ? 'selected' : '' }}>0 - 25,000</option>
                                                            <option value="25001-50000" {{ old('income_range') == '25001-50000' ? 'selected' : '' }}>25,001 - 50,000</option>
                                                            <option value="50001-75000" {{ old('income_range') == '50001-75000' ? 'selected' : '' }}>50,001 - 75,000</option>
                                                            <option value="75001-100000" {{ old('income_range') == '75001-100000' ? 'selected' : '' }}>75,001 - 100,000</option>
                                                            <option value="100001+" {{ old('income_range') == '100001+' ? 'selected' : '' }}>100,001+</option>
                                                        </select>
                                                        @error('income_range')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group-inner">
                                                <div class="row">
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                        <label class="login2">Education Level</label>
                                                    </div>
                                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                        <select class="form-control @error('education_level') is-invalid @enderror" name="education_level">
                                                            <option value="">Select Education Level</option>
                                                            <option value="high_school" {{ old('education_level') == 'high_school' ? 'selected' : '' }}>High School</option>
                                                            <option value="some_college" {{ old('education_level') == 'some_college' ? 'selected' : '' }}>Some College</option>
                                                            <option value="associate" {{ old('education_level') == 'associate' ? 'selected' : '' }}>Associate Degree</option>
                                                            <option value="bachelor" {{ old('education_level') == 'bachelor' ? 'selected' : '' }}>Bachelor's Degree</option>
                                                            <option value="master" {{ old('education_level') == 'master' ? 'selected' : '' }}>Master's Degree</option>
                                                            <option value="doctorate" {{ old('education_level') == 'doctorate' ? 'selected' : '' }}>Doctorate</option>
                                                        </select>
                                                        @error('education_level')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group-inner">
                                                <div class="row">
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                        <label class="login2">Relation Type*</label>
                                                    </div>
                                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                        <select class="form-control @error('relation_type') is-invalid @enderror" name="relation_type" >
                                                            <option value="">Select Relation</option>
                                                            <option value="father" {{ old('relation_type') == 'father' ? 'selected' : '' }}>Father</option>
                                                            <option value="mother" {{ old('relation_type') == 'mother' ? 'selected' : '' }}>Mother</option>
                                                            <option value="guardian" {{ old('relation_type') == 'guardian' ? 'selected' : '' }}>Guardian</option>
                                                            <option value="grandparent" {{ old('relation_type') == 'grandparent' ? 'selected' : '' }}>Grandparent</option>
                                                            <option value="other" {{ old('relation_type') == 'other' ? 'selected' : '' }}>Other</option>
                                                        </select>
                                                        @error('relation_type')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group-inner">
                                                <div class="row">
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                        <label class="login2">Emergency Contact*</label>
                                                    </div>
                                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                        <input type="text" class="form-control @error('emergency_contact') is-invalid @enderror" 
                                                               name="emergency_contact" value="{{ old('emergency_contact') }}"  />
                                                        @error('emergency_contact')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Children Information Section -->
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="all-form-element-inner">
                                            <div class="section-headline">
                                                <h3>Children Information</h3>
                                            </div>
                                            <div id="children-container">
                                                <div class="child-entry">
                                                    <div class="form-group-inner">
                                                        <div class="row">
                                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                                <label class="login2">Student/Child*</label>
                                                            </div>
                                                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                                <select name="children[]" class="chosen-select @error('children') is-invalid @enderror" multiple tabindex="-1" >
                                                                    @foreach($students as $student)
                                                                        <option value="{{ $student->id }}" {{ in_array($student->id, old('children', [])) ? 'selected' : '' }}>
                                                                            {{ $student->name }} ({{ $student->studentProfile->admission_no ?? 'N/A' }})
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                                @error('children')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group-inner">
                                                        <div class="row">
                                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                                <label class="login2">Is Primary Parent</label>
                                                            </div>
                                                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                                <div class="bt-df-checkbox">
                                                                    <input type="checkbox" name="is_primary" value="1" {{ old('is_primary') ? 'checked' : '' }}>
                                                                    <span class="checkmark"></span>
                                                                </div>
                                                                @error('is_primary')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr>
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
                                                        <label class="login2">Address Proof*</label>
                                                    </div>
                                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                        <input type="file" class="form-control @error('address_proof') is-invalid @enderror" name="address_proof"  />
                                                        @error('address_proof')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group-inner">
                                                <div class="row">
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                        <label class="login2">ID Proof*</label>
                                                    </div>
                                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                        <input type="file" class="form-control @error('id_proof') is-invalid @enderror" name="id_proof"  />
                                                        @error('id_proof')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group-inner">
                                                <div class="row">
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                        <label class="login2">Other Documents</label>
                                                    </div>
                                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                        <input type="file" class="form-control @error('documents.*') is-invalid @enderror" name="documents[]" multiple />
                                                        @error('documents.*')
                                                            <div class="invalid-feedback">{{ $message }}</div>
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
                                                            <button class="btn btn-sm btn-primary login-submit-cs" type="submit">Register Parent</button>
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
    @endpush
    
</x-tenant-app-layout>