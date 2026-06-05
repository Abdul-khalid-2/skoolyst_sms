<x-tenant-app-layout>
    @push('css')
        <link rel="stylesheet" href="{{ asset('backend/css/touchspin/jquery.bootstrap-touchspin.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/datapicker/datepicker3.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/form/themesaller-forms.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/colorpicker/colorpicker.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/select2/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/chosen/bootstrap-chosen.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/ionRangeSlider/ion.rangeSlider.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/ionRangeSlider/ion.rangeSlider.skinFlat.css') }}">
    @endpush
    <x-slot name="header"></x-slot>
    
    <!-- Advanced Form Start -->
    <div class="advanced-form-area mg-b-15">
        <div class="container-fluid">
            <div class="row">
                
                <x-page-header
                    title="Edit Class"
                    :back-route="route('admin.academic.classes.index')"
                />
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline12-list">
                        <div class="sparkline12-graph">
                            <div class="basic-login-form-ad">
                                <div class="row">
                                    <form method="POST" action="{{ route('admin.academic.classes.update',$class->id) }}">
                                        @csrf
                                        @method('PUT')

                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="all-form-element-inner">
                                                                                                
                                                <div class="form-group-inner {{ $errors->has('name') ? 'has-error' : '' }}">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <label class="login2">Class Name*</label>
                                                        </div>
                                                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                            <input type="text" class="form-control" name="name" value="{{ $class->name??'--' }}" required />
                                                            @if($errors->has('name'))
                                                                <span class="help-block text-danger">{{ $errors->first('name') }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group-inner {{ $errors->has('numeric_value') ? 'has-error' : '' }}">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <label class="login2">Numeric Value*</label>
                                                        </div>
                                                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                            <input type="number" class="form-control" name="numeric_value" 
                                                                   value="{{ $class->numeric_value??"--" }}" min="0" required />
                                                            @if($errors->has('numeric_value'))
                                                                <span class="help-block text-danger">{{ $errors->first('numeric_value') }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group-inner {{ $errors->has('teacher_id') ? 'has-error' : '' }}">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <label class="login2">Class Teacher</label>
                                                        </div>
                                                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                            <select class="form-control chosen-select" name="teacher_id">
                                                                <option value="">-- Select Teacher --</option>
                                                                @foreach($teachers as $teacher)
                                                                    <option value="{{ $teacher->id }}" 
                                                                        {{ $class->teacher_id == $teacher->id ? 'selected' : '' }}>
                                                                        {{ $teacher->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            @if($errors->has('teacher_id'))
                                                                <span class="help-block text-danger">{{ $errors->first('teacher_id') }}</span>
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
                                                                    Create Class
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
        <script src="{{ asset('backend/js/touchspin/jquery.bootstrap-touchspin.min.js') }}"></script>
        <script src="{{ asset('backend/js/touchspin/touchspin-active.js') }}"></script>
        <script src="{{ asset('backend/js/colorpicker/jquery.spectrum.min.js') }}"></script>
        <script src="{{ asset('backend/js/colorpicker/color-picker-active.js') }}"></script>
        <script src="{{ asset('backend/js/datapicker/bootstrap-datepicker.js') }}"></script>
        <script src="{{ asset('backend/js/datapicker/datepicker-active.js') }}"></script>
        <script src="{{ asset('backend/js/input-mask/jasny-bootstrap.min.js') }}"></script>
        <script src="{{ asset('backend/js/chosen/chosen.jquery.js') }}"></script>
        <script src="{{ asset('backend/js/chosen/chosen-active.js') }}"></script>
        <script src="{{ asset('backend/js/select2/select2.full.min.js') }}"></script>
        <script src="{{ asset('backend/js/select2/select2-active.js') }}"></script>
        <script src="{{ asset('backend/js/ionRangeSlider/ion.rangeSlider.min.js') }}"></script>
        <script src="{{ asset('backend/js/ionRangeSlider/ion.rangeSlider.active.js') }}"></script>
        <script src="{{ asset('backend/js/rangle-slider/jquery-ui-1.10.4.custom.min.js') }}"></script>
        <script src="{{ asset('backend/js/rangle-slider/jquery-ui-touch-punch.min.js') }}"></script>
        <script src="{{ asset('backend/js/rangle-slider/rangle-active.js') }}"></script>
        <script src="{{ asset('backend/js/knob/jquery.knob.js') }}"></script>
        <script src="{{ asset('backend/js/knob/knob-active.js') }}"></script>
        <script src="{{ asset('backend/js/tab.js') }}"></script>

        <script>
            // Initialize chosen select
            $(".chosen-select").chosen();
        </script>

    @endpush
</x-tenant-app-layout>

