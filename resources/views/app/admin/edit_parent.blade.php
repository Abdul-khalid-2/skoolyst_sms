<x-tenant-app-layout>
    @push('css')
        {{-- Page-specific CSS only — globals (bootstrap, font-awesome, owl, animate,
             normalize, meanmenu, main, educate, morris, scrollbar, metisMenu,
             calendar, responsive, modernizr) are already loaded in the layout. --}}
        <link rel="stylesheet" href="{{ asset('backend/css/touchspin/jquery.bootstrap-touchspin.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/datapicker/datepicker3.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/form/themesaller-forms.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/colorpicker/colorpicker.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/select2/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/chosen/bootstrap-chosen.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/ionRangeSlider/ion.rangeSlider.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/ionRangeSlider/ion.rangeSlider.skinFlat.css') }}">

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

    @php
        $profile = $parent->parentProfile;
    @endphp

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="breadcome-list">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="breadcome-heading" style="margin-top: 10px">
                                <h3>Edit Parent</h3>
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
                                <form id="parentForm" method="POST" action="{{ route('admin.update.parent', $parent->id) }}" enctype="multipart/form-data">
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
                                                        <label class="login2">Full Name*</label>
                                                    </div>
                                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                                               name="name" value="{{ old('name', $parent->name) }}"  />
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
                                                               name="email" value="{{ old('email', $parent->email) }}"  />
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
                                                               name="phone" value="{{ old('phone', $parent->phone) }}"  />
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
                                                                  name="address" >{{ old('address', $parent->address) }}</textarea>
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
                                                        @php $gender = old('gender', $parent->gender); @endphp
                                                        <select class="form-control @error('gender') is-invalid @enderror" name="gender" >
                                                            <option value="">Select Gender</option>
                                                            <option value="male" {{ $gender == 'male' ? 'selected' : '' }}>Male</option>
                                                            <option value="female" {{ $gender == 'female' ? 'selected' : '' }}>Female</option>
                                                            <option value="other" {{ $gender == 'other' ? 'selected' : '' }}>Other</option>
                                                        </select>
                                                        @error('gender')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
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
                                                               name="occupation" value="{{ old('occupation', $profile->occupation ?? '') }}"  />
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
                                                               name="employer" value="{{ old('employer', $profile->employer ?? '') }}" />
                                                        @error('employer')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group-inner">
                                                <div class="row">
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                        <label class="login2">Income Range*</label>
                                                    </div>
                                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                        @php $incomeRange = old('income_range', $profile->income_range ?? ''); @endphp
                                                        <input type="text" class="form-control @error('income_range') is-invalid @enderror"
                                                               name="income_range" value="{{ $incomeRange }}"
                                                               placeholder="e.g. 50000-100000" />
                                                        @error('income_range')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group-inner">
                                                <div class="row">
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                        <label class="login2">Education Level*</label>
                                                    </div>
                                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                        @php $educationLevel = old('education_level', $profile->education_level ?? ''); @endphp
                                                        <input type="text" class="form-control @error('education_level') is-invalid @enderror"
                                                               name="education_level" value="{{ $educationLevel }}"
                                                               placeholder="e.g. Bachelors" />
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
                                                        @php $relationType = old('relation_type', $profile->relation_type ?? ''); @endphp
                                                        <select class="form-control @error('relation_type') is-invalid @enderror" name="relation_type" >
                                                            <option value="">Select Relation</option>
                                                            <option value="father" {{ $relationType == 'father' ? 'selected' : '' }}>Father</option>
                                                            <option value="mother" {{ $relationType == 'mother' ? 'selected' : '' }}>Mother</option>
                                                            <option value="guardian" {{ $relationType == 'guardian' ? 'selected' : '' }}>Guardian</option>
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
                                                               name="emergency_contact" value="{{ old('emergency_contact', $profile->emergency_contact ?? '') }}"  />
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
                                                                @php $childIds = old('children', $selectedChildren ?? []); @endphp
                                                                <select name="children[]" class="chosen-select @error('children') is-invalid @enderror" multiple tabindex="-1" >
                                                                    @foreach($students as $student)
                                                                        <option value="{{ $student->id }}" {{ in_array($student->id, $childIds) ? 'selected' : '' }}>
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
                                                                    <input type="checkbox" name="is_primary" value="1" {{ old('is_primary', $profile->is_primary ?? false) ? 'checked' : '' }}>
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
                                                <h3>Documents <small>(leave blank to keep existing)</small></h3>
                                            </div>
                                            <div class="form-group-inner">
                                                <div class="row">
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                        <label class="login2">Address Proof</label>
                                                    </div>
                                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                        <input type="file" class="form-control @error('address_proof') is-invalid @enderror" name="address_proof"  />
                                                        @if(!empty($profile->address_proof))
                                                            <small class="text-muted">Current: {{ basename($profile->address_proof) }}</small>
                                                        @endif
                                                        @error('address_proof')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group-inner">
                                                <div class="row">
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                        <label class="login2">ID Proof</label>
                                                    </div>
                                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                        <input type="file" class="form-control @error('id_proof') is-invalid @enderror" name="id_proof"  />
                                                        @if(!empty($profile->id_proof))
                                                            <small class="text-muted">Current: {{ basename($profile->id_proof) }}</small>
                                                        @endif
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
                                                            <button class="btn btn-sm btn-primary login-submit-cs" type="submit">Update Parent</button>
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
        {{-- Page-specific JS only — jQuery, bootstrap, wow, price-slider, meanmenu,
             owl.carousel, sticky, scrollUp, mCustomScrollbar, metisMenu, plugins
             and main are already loaded in the layout. --}}
        <script src="{{ asset('backend/js/chosen/chosen.jquery.js') }}"></script>
        <script src="{{ asset('backend/js/chosen/chosen-active.js') }}"></script>
        <script src="{{ asset('backend/js/select2/select2.full.min.js') }}"></script>
        <script src="{{ asset('backend/js/select2/select2-active.js') }}"></script>
        <script src="{{ asset('backend/js/tab.js') }}"></script>
        <script>
            $(document).ready(function() {
                $('#parentForm').submit(function(e) {
                    let isValid = true;

                    // Clear previous errors
                    $('.is-invalid').removeClass('is-invalid');
                    $('.invalid-feedback').remove();

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
