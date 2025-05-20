{{-- <x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout> --}}
<x-app-two-layout>
    @push('css')
        <!-- favicon
		============================================ -->
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
        <!-- x-editor CSS
            ============================================ -->
        <link rel="stylesheet" href="{{ asset('backend/css/editor/select2.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/editor/datetimepicker.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/editor/bootstrap-editable.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/editor/x-editor-style.css') }}">
        <!-- normalize CSS
            ============================================ -->
        <link rel="stylesheet" href="{{ asset('backend/css/data-table/bootstrap-table.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/data-table/bootstrap-editable.css') }}">
        <!-- style CSS
            ============================================ -->
        
        <!-- responsive CSS
            ============================================ -->
        <link rel="stylesheet" href="{{ asset('backend/css/responsive.css') }}">
        <!-- modernizr JS
            ============================================ -->
        <script src="{{ asset('backend/js/vendor/modernizr-2.8.3.min.js') }}"></script>
    @endpush
   


    <div class="error-pagewrap">
        <div class="error-page-int">
            <div class="text-center custom-login">
                <h3>Registration</h3>
                <p>This is the best app ever!</p>
            </div>
            <div class="content-error">
                <div class="hpanel">
                    <div class="panel-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
    
                            <!-- Name -->
                            <div class="form-group">
                                <label class="control-label" for="name">Full Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name') }}" 
                                       required autofocus autocomplete="name"
                                       placeholder="Enter your full name">
                                @error('name')
                                    <span class="help-block small text-danger">{{ $message }}</span>
                                @else
                                    <span class="help-block small">Your full name</span>
                                @enderror
                            </div>
    
                            <!-- Email Address -->
                            <div class="form-group">
                                <label class="control-label" for="email">Email Address</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email') }}" 
                                       required autocomplete="email"
                                       placeholder="example@gmail.com">
                                @error('email')
                                    <span class="help-block small text-danger">{{ $message }}</span>
                                @else
                                    <span class="help-block small">Your email address</span>
                                @enderror
                            </div>
    
                            <!-- Password -->
                            <div class="row">
                                <div class="form-group col-lg-6">
                                    <label class="control-label" for="password">Password</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                           id="password" name="password" 
                                           required autocomplete="new-password"
                                           placeholder="******">
                                    @error('password')
                                        <span class="help-block small text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
    
                                <!-- Confirm Password -->
                                <div class="form-group col-lg-6">
                                    <label class="control-label" for="password_confirmation">Confirm Password</label>
                                    <input type="password" class="form-control" 
                                           id="password_confirmation" name="password_confirmation" 
                                           required autocomplete="new-password"
                                           placeholder="******">
                                    <span class="help-block small">Re-type your password</span>
                                </div>
                            </div>
    
                            <!-- Newsletter Subscription -->
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" class="i-checks" name="newsletter" value="1"> 
                                    Sign up for our newsletter
                                </label>
                            </div>
    
                            <div class="text-center">
                                <button type="submit" class="btn btn-success loginbtn">Register</button>
                               
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="text-center login-footer">
                <p> If you have account : 
                    @if (Route::has('login'))
                        <a href="{{ route('login') }}" >Already registered?</a>
                    @endif
                </p>
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
   @endpush

    
</x-app-two-layout>
