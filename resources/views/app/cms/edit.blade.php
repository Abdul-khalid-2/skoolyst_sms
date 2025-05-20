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
            .color-preview {
                width: 30px;
                height: 30px;
                border-radius: 4px;
                display: inline-block;
                vertical-align: middle;
                margin-left: 10px;
            }
            .program-item, .testimonial-item {
                border: 1px solid #e2e8f0;
                border-radius: 0.5rem;
                padding: 1rem;
                margin-bottom: 1rem;
                background-color: #f8fafc;
            }
        </style>
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
                                    <h3>School Landing Page CMS</h3>
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
                        <div class="sparkline12-graph">
                            <div class="basic-login-form-ad">
                                <div >
                                    <form method="POST" action="{{ route('schools.cms.update') }}" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
            
                                        <!-- Basic Information -->
                                        <div class="mb-5">
                                            <h5 class="mb-3 font-bold text-lg">Basic Information</h5>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>School Name</label>
                                                        <input type="text" name="name" class="form-control" value="{{ $school->name }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>School Motto</label>
                                                        <input type="text" name="motto" class="form-control" value="{{ $school->motto }}">
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="row mt-3">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Primary Color</label>
                                                        <div class="input-group">
                                                            <input type="color" name="primary_color" class="form-control" value="{{ $school->primary_color }}">
                                                            <span class="color-preview" style="background-color: {{ $school->primary_color }}"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Secondary Color</label>
                                                        <div class="input-group">
                                                            <input type="color" name="secondary_color" class="form-control" value="{{ $school->secondary_color }}">
                                                            <span class="color-preview" style="background-color: {{ $school->secondary_color }}"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="row mt-3">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Logo</label>
                                                        <input type="file" name="logo" class="form-control">
                                                        @if($school->logo)
                                                            <div class="mt-2">
                                                                <img src="{{ asset('tenancy/assets/' . $school->logo) }}" alt="Current Logo" style="max-height: 100px;">
                                                                <label class="mt-2">
                                                                    <input type="checkbox" name="remove_logo"> Remove current logo
                                                                </label>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Hero Image</label>
                                                        <input type="file" name="hero_image" class="form-control">
                                                        @if($school->hero_image)
                                                            <div class="mt-2">
                                                                <img src="{{ asset($school->hero_image) }}" alt="Current Hero Image" style="max-height: 100px;">
                                                                <label class="mt-2">
                                                                    <input type="checkbox" name="remove_hero_image"> Remove current hero image
                                                                </label>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
            
                                        <!-- Statistics -->
                                        <div class="mb-5">
                                            <h5 class="mb-3 font-bold text-lg">School Statistics</h5>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Established Year</label>
                                                        <input type="text" name="established_year" class="form-control" value="{{ $school->established_year }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Student Count</label>
                                                        <input type="text" name="student_count" class="form-control" value="{{ $school->student_count }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Teacher Count</label>
                                                        <input type="text" name="teacher_count" class="form-control" value="{{ $school->teacher_count }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Facility Count</label>
                                                        <input type="text" name="facility_count" class="form-control" value="{{ $school->facility_count }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
            
                                        <!-- Contact Information -->
                                        <div class="mb-5">
                                            <h5 class="mb-3 font-bold text-lg">Contact Information</h5>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Address</label>
                                                        <textarea name="address" class="form-control" rows="2">{{ $school->address }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Phone Number</label>
                                                        <input type="text" name="phone" class="form-control" value="{{ $school->phone }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Email</label>
                                                        <input type="email" name="email" class="form-control" value="{{ $school->email }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Short Description (For Footer)</label>
                                                        <textarea name="short_description" class="form-control" rows="3">{{ $school->short_description }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
            
                                        <!-- Academic Programs -->
                                        <div class="mb-5">
                                            <h5 class="mb-3 font-bold text-lg">Academic Programs</h5>
                                            <div id="programs-container">
                                                @foreach($school->programs as $index => $program)
                                                    <div class="program-item" data-index="{{ $index }}">
                                                        <div class="row">
                                                            <div class="col-md-5">
                                                                <div class="form-group">
                                                                    <label>Program Name</label>
                                                                    <input type="text" name="programs[{{ $index }}][name]" class="form-control" value="{{ $program->name }}" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Description</label>
                                                                    <textarea name="programs[{{ $index }}][description]" class="form-control" rows="2" required>{{ $program->description }}</textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-1 d-flex align-items-end">
                                                                <button type="button" class="btn btn-danger remove-program" data-index="{{ $index }}">
                                                                    <i class="fa fa-trash"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="programs[{{ $index }}][id]" value="{{ $program->id }}">
                                                    </div>
                                                @endforeach
                                            </div>
                                            <button type="button" id="add-program" class="btn btn-secondary mt-2">
                                                <i class="fa fa-plus"></i> Add Program
                                            </button>
                                        </div>
            
                                        <!-- Testimonials -->
                                        <div class="mb-5">
                                            <h5 class="mb-3 font-bold text-lg">Testimonials</h5>
                                            <div id="testimonials-container">
                                                @foreach($school->testimonials as $index => $testimonial)
                                                    <div class="testimonial-item" data-index="{{ $index }}">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label>Author Name</label>
                                                                    <input type="text" name="testimonials[{{ $index }}][author]" class="form-control" value="{{ $testimonial->author }}" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>Role</label>
                                                                    <input type="text" name="testimonials[{{ $index }}][role]" class="form-control" value="{{ $testimonial->role }}" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label>Rating (1-5)</label>
                                                                    <select name="testimonials[{{ $index }}][rating]" class="form-control" required>
                                                                        @for($i = 1; $i <= 5; $i++)
                                                                            <option value="{{ $i }}" {{ $testimonial->rating == $i ? 'selected' : '' }}>{{ $i }}</option>
                                                                        @endfor
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label>Avatar</label>
                                                                    <input type="file" name="testimonials[{{ $index }}][avatar]" class="form-control">
                                                                    @if($testimonial->avatar)
                                                                        <img src="{{ asset($testimonial->avatar) }}" alt="Current Avatar" style="max-height: 50px;">
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="col-md-1 d-flex align-items-end">
                                                                <button type="button" class="btn btn-danger remove-testimonial" data-index="{{ $index }}">
                                                                    <i class="fa fa-trash"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-2">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label>Content</label>
                                                                    <textarea name="testimonials[{{ $index }}][content]" class="form-control" rows="2" required>{{ $testimonial->content }}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="testimonials[{{ $index }}][id]" value="{{ $testimonial->id }}">
                                                    </div>
                                                @endforeach
                                            </div>
                                            <button type="button" id="add-testimonial" class="btn btn-secondary mt-2">
                                                <i class="fa fa-plus"></i> Add Testimonial
                                            </button>
                                        </div>
            
                                        <div class="form-group text-right">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fa fa-save"></i> Save Changes
                                            </button>
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
        <script>
            $(document).ready(function() {
                // Add new program
                let programIndex = {{ count($school->programs) }};
                $('#add-program').click(function() {
                    const template = `
                        <div class="program-item" data-index="${programIndex}">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label>Program Name</label>
                                        <input type="text" name="programs[${programIndex}][name]" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea name="programs[${programIndex}][description]" class="form-control" rows="2" required></textarea>
                                    </div>
                                </div>
                                <div class="col-md-1 d-flex align-items-end">
                                    <button type="button" class="btn btn-danger remove-program" data-index="${programIndex}">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    `;
                    $('#programs-container').append(template);
                    programIndex++;
                });

                // Remove program
                $(document).on('click', '.remove-program', function() {
                    const index = $(this).data('index');
                    $(`[data-index="${index}"]`).remove();
                });

                // Add new testimonial
                let testimonialIndex = {{ count($school->testimonials) }};
                $('#add-testimonial').click(function() {
                    const template = `
                        <div class="testimonial-item" data-index="${testimonialIndex}">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Author Name</label>
                                        <input type="text" name="testimonials[${testimonialIndex}][author]" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Role</label>
                                        <input type="text" name="testimonials[${testimonialIndex}][role]" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Rating (1-5)</label>
                                        <select name="testimonials[${testimonialIndex}][rating]" class="form-control" required>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5" selected>5</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Avatar</label>
                                        <input type="file" name="testimonials[${testimonialIndex}][avatar]" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-1 d-flex align-items-end">
                                    <button type="button" class="btn btn-danger remove-testimonial" data-index="${testimonialIndex}">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Content</label>
                                        <textarea name="testimonials[${testimonialIndex}][content]" class="form-control" rows="2" required></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    $('#testimonials-container').append(template);
                    testimonialIndex++;
                });

                // Remove testimonial
                $(document).on('click', '.remove-testimonial', function() {
                    const index = $(this).data('index');
                    $(`[data-index="${index}"]`).remove();
                });

                // Color preview update
                $('input[name="primary_color"], input[name="secondary_color"]').on('change', function() {
                    const color = $(this).val();
                    const preview = $(this).closest('.form-group').find('.color-preview');
                    preview.css('background-color', color);
                });
            });
        </script>
    @endpush
</x-tenant-app-layout>