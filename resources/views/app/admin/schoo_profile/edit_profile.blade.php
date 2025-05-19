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
        .logo-preview {
            max-width: 200px;
            max-height: 200px;
            margin-bottom: 15px;
        }
        .form-section {
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #eee;
        }
        .form-section h3 {
            margin-bottom: 20px;
            color: #333;
        }
    </style>
    @endpush

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit School Profile') }}
        </h2>
    </x-slot>

    <div class="container-fluid">
        <div class="row">
          
                    
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="breadcome-list">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="breadcome-heading" style="margin-top: 10px">
                                    <h3>Edit School Profile Form</h3>
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
                        <form action="{{ route('schools.update', $school->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <!-- Display general form errors at the top -->
                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            
                            <div class="form-section">
                                <h3>Basic Information</h3>
                                <div class="settings-group">
                                    <label class="settings-label">School Logo</label>
                                    @if($school->logo)
                                    <div class="mb-2">
                                        <img src="{{ asset('tenancy/assets/' .$school->logo)  }}" alt="School Logo" style="max-height: 100px;">
                                    </div>
                                    @endif
                                    <input type="file" name="logo" class="form-control">
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>School Name *</label>
                                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $school->name) }}" required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Academic Session *</label>
                                            <input type="text" name="session_year" class="form-control @error('session_year') is-invalid @enderror" value="{{ old('session_year', $school->session_year) }}" required>
                                            @error('session_year')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>School Type</label>
                                            <select name="type" class="form-control @error('type') is-invalid @enderror">
                                                <option value="">Select Type</option>
                                                <option value="public" {{ old('type', $school->type) == 'public' ? 'selected' : '' }}>Public School</option>
                                                <option value="private" {{ old('type', $school->type) == 'private' ? 'selected' : '' }}>Private School</option>
                                                <option value="international" {{ old('type', $school->type) == 'international' ? 'selected' : '' }}>International School</option>
                                            </select>
                                            @error('type')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Affiliation Number</label>
                                            <input type="text" name="affiliation" class="form-control @error('affiliation') is-invalid @enderror" value="{{ old('affiliation', $school->affiliation) }}">
                                            @error('affiliation')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label>About School</label>
                                    <textarea name="about" class="form-control @error('about') is-invalid @enderror" rows="3">{{ old('about', $school->about) }}</textarea>
                                    @error('about')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="form-section">
                                <h3>Contact Information</h3>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Address *</label>
                                            <textarea name="address" class="form-control @error('address') is-invalid @enderror" rows="3" required>{{ old('address', $school->address) }}</textarea>
                                            @error('address')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Phone Number *</label>
                                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $school->phone) }}" required>
                                            @error('phone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Email Address *</label>
                                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $school->email) }}" required>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Website</label>
                                            <input type="url" name="website" class="form-control @error('website') is-invalid @enderror" value="{{ old('website', $school->website) }}" placeholder="https://">
                                            @error('website')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Principal Name</label>
                                            <input type="text" name="principal" class="form-control @error('principal') is-invalid @enderror" value="{{ old('principal', $school->principal) }}">
                                            @error('principal')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label>Social Media Links</label>
                                @php
                                    $socialLinks = $school->social_links ? json_decode($school->social_links, true) : [];
                                @endphp
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="url" name="social_links[facebook]" class="form-control mb-2 @error('social_links.facebook') is-invalid @enderror" 
                                                value="{{ old('social_links.facebook', $socialLinks['facebook'] ?? '') }}" 
                                                placeholder="Facebook URL">
                                        @error('social_links.facebook')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <input type="url" name="social_links[twitter]" class="form-control mb-2 @error('social_links.twitter') is-invalid @enderror" 
                                                value="{{ old('social_links.twitter', $socialLinks['twitter'] ?? '') }}" 
                                                placeholder="Twitter URL">
                                        @error('social_links.twitter')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <input type="url" name="social_links[instagram]" class="form-control mb-2 @error('social_links.instagram') is-invalid @enderror" 
                                                value="{{ old('social_links.instagram', $socialLinks['instagram'] ?? '') }}" 
                                                placeholder="Instagram URL">
                                        @error('social_links.instagram')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <input type="url" name="social_links[youtube]" class="form-control mb-2 @error('social_links.youtube') is-invalid @enderror" 
                                                value="{{ old('social_links.youtube', $socialLinks['youtube'] ?? '') }}" 
                                                placeholder="YouTube URL">
                                        @error('social_links.youtube')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>                                        
                            
                            <div class="form-section">
                                <h3>Additional Information</h3>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Established Year</label>
                                            <input type="number" name="established_year" class="form-control @error('established_year') is-invalid @enderror" value="{{ old('established_year', $school->established_year) }}" min="1900" max="{{ date('Y') }}">
                                            @error('established_year')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Working Hours</label>
                                            <input type="text" name="working_hours" class="form-control @error('working_hours') is-invalid @enderror" value="{{ old('working_hours', $school->working_hours) }}" placeholder="e.g. 8:00 AM - 3:00 PM">
                                            @error('working_hours')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div> --}}
                                </div>
                            </div>
                            
                            <div class="text-right">
                                <button type="reset" class="btn btn-default">Reset</button>
                                <button type="submit" class="btn btn-primary">Update Profile</button>
                            </div>
                        </form>
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
            // Preview logo before upload
            $('input[name="logo"]').change(function(e) {
                if (this.files && this.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        if ($('.current-logo').length) {
                            $('.current-logo img').attr('src', e.target.result);
                        } else {
                            $('input[name="logo"]').before('<div class="current-logo"><p>New Logo Preview:</p><img src="'+e.target.result+'" class="logo-preview"></div>');
                        }
                    }
                    reader.readAsDataURL(this.files[0]);
                }
            });
        });
    </script>
    @endpush
</x-tenant-app-layout>