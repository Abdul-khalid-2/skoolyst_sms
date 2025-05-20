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
                                    <h3>Add New Section</h3>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="action-buttons">
                                    <a href="{{ route('admin.academic.sections.index') }}" 
                                           class="btn btn-primary btn-sm" style="color: white">
                                            <i class="fa fa-arrow-left"></i> Back
                                        </a>
                                </div>
                                <div class="dropdown-container">
                                    <button class="dropdown-toggle-custom">
                                        <i class="fa fa-ellipsis-v"></i>
                                    </button>
                                    <div class="dropdown-menu-custom">
                                        <a href="{{ route('admin.academic.sections.index') }}" 
                                           class="btn btn-primary btn-sm" style="color: white">
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
                                    <form method="POST" action="{{ route('admin.academic.sections.update', encrypt($section->id)) }}">
                                        @csrf
                                        @method('PUT')
                                        
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="all-form-element-inner">
                                                <div class="section-headline">
                                                    <h3>Update Section Information</h3>
                                                </div>
                                                
                                                <div class="form-group-inner {{ $errors->has('class_id') ? 'has-error' : '' }}">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <label class="login2">Class*</label>
                                                        </div>
                                                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                            <select class="form-control chosen-select" name="class_id" required>
                                                                <option value="">-- Select Class --</option>
                                                                @foreach($classes as $class)
                                                                    <option value="{{ $class->id }}" 
                                                                        {{ $section->class_id == $class->id ? 'selected' : '' }}>
                                                                        {{ $class->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            @if($errors->has('class_id'))
                                                                <span class="help-block text-danger">{{ $errors->first('class_id') }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group-inner {{ $errors->has('name') ? 'has-error' : '' }}">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <label class="login2">Section Name*</label>
                                                        </div>
                                                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                            <input type="text" class="form-control" name="name" 
                                                                value="{{ old('name', $section->name) }}" required />
                                                            @if($errors->has('name'))
                                                                <span class="help-block text-danger">{{ $errors->first('name') }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group-inner {{ $errors->has('capacity') ? 'has-error' : '' }}">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <label class="login2">Capacity*</label>
                                                        </div>
                                                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                            <input type="number" class="form-control" name="capacity" 
                                                                value="{{ old('capacity', $section->capacity) }}" min="1" required />
                                                            @if($errors->has('capacity'))
                                                                <span class="help-block text-danger">{{ $errors->first('capacity') }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group-inner">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"></div>
                                                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                            <div class="login-horizental">
                                                                <button class="btn btn-sm btn-primary login-submit-cs" type="submit">
                                                                    Update Section
                                                                </button>
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
    </div>
    <!-- Advanced Form End-->

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
            // Initialize chosen select
            $(".chosen-select").chosen();
        </script>

    @endpush
</x-tenant-app-layout>