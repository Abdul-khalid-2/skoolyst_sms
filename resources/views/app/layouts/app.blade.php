
<!doctype html>
<html class="no-js" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{ isset($invormentdata->name) ? $invormentdata->name : 'Schoo Management System'  }}</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('backend/img/favicon.ico') }}">
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
    <link rel="stylesheet" href="{{ asset('backend/css/responsive.css') }}">
    @stack('css')
    <link rel="stylesheet" href="{{ asset('backend/style.css') }}">
    <script src="{{ asset('backend/js/vendor/modernizr-2.8.3.min.js') }}"></script>
    
    <style>
        .main-logo {
            height: 30px; /* or whatever size you prefer */
            width: auto; /* maintains aspect ratio */
            max-height: 100%; /* ensures it doesn't exceed container */
        }
    </style>
    <style>
        .action-buttons {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
        }

        .dropdown-container {
            position: relative;
            display: none;
        }

        .dropdown-toggle-custom {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 6px 10px;
            border-radius: 4px;
            font-size: 18px;
            cursor: pointer;
        }

        .dropdown-menu-custom {
            position: absolute;
            top: 35px;
            left: 0;
            background: white;
            border: 1px solid #ddd;
            border-radius: 4px;
            min-width: 160px;
            display: none;
            z-index: 1000;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
        }

        .dropdown-menu-custom a {
            display: block;
            padding: 10px 15px;
            text-decoration: none;
            color: #333;
            font-size: 14px;
            border-bottom: 1px solid #eee;
        }

        .dropdown-menu-custom a:last-child {
            border-bottom: none;
        }

        .dropdown-container:hover .dropdown-menu-custom {
            display: block;
        }

        /* Responsive */
        @media (max-width: 767.98px) {
            .action-buttons {
                display: none;
            }

            .dropdown-container {
                display: inline-block;
            }
            
            .col-lg-6.col-md-6.col-sm-6.col-xs-12:last-child {
                display: flex;
                justify-content: flex-start;
                margin-top: 10px;
            }
        }
        
        @media (min-width: 768px) {
            .col-lg-6.col-md-6.col-sm-6.col-xs-12:last-child {
                display: flex;
                justify-content: flex-end;
            }
        }
    </style>
</head>

<body>

     <div class="left-sidebar-pro">
        @include('app.layouts.sidebar')
    </div>

    <div class="all-content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 20px">
                    <div class="logo-pro">
                        <a href="{{ route('dashboard') }}">
                            <img class="main-logo" src="{{ $invormentdata->logo_url }}" alt="{{ $invormentdata->name }} Logo"/>
                        </a>
                        <span class="ml-2 text-2xl font-bold text-gray-800">{{ $invormentdata->name ?? 'Skoolyst' }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- header navigation code is here  --}}
        
        
        @isset($header)
            @include('app.layouts.navigation')
        @endisset

        {{ $slot }}


    </div>

    <script src="{{ asset('backend/js/vendor/jquery-1.12.4.min.js') }}"></script>
    <script src="{{ asset('backend/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('backend/js/wow.min.js') }}"></script>
    <script src="{{ asset('backend/js/jquery-price-slider.js') }}"></script>
    <script src="{{ asset('backend/js/jquery.meanmenu.js') }}"></script>
    <script src="{{ asset('backend/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('backend/js/jquery.sticky.js') }}"></script>
    <script src="{{ asset('backend/js/jquery.scrollUp.min.js') }}"></script>
    <script src="{{ asset('backend/js/counterup/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('backend/js/counterup/waypoints.min.js') }}"></script>
    <script src="{{ asset('backend/js/counterup/counterup-active.js') }}"></script>
    <script src="{{ asset('backend/js/scrollbar/jquery.mCustomScrollbar.concat.min.js') }}"></script>
    <script src="{{ asset('backend/js/scrollbar/mCustomScrollbar-active.js') }}"></script>
    <script src="{{ asset('backend/js/metisMenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('backend/js/metisMenu/metisMenu-active.js') }}"></script>
    <script src="{{ asset('backend/js/sparkline/jquery.sparkline.min.js') }}"></script>
    <script src="{{ asset('backend/js/sparkline/jquery.charts-sparkline.js') }}"></script>
    <script src="{{ asset('backend/js/sparkline/sparkline-active.js') }}"></script>
    <script src="{{ asset('backend/js/calendar/moment.min.js') }}"></script>
    <script src="{{ asset('backend/js/calendar/fullcalendar.min.js') }}"></script>
    <script src="{{ asset('backend/js/calendar/fullcalendar-active.js') }}"></script>
    <script src="{{ asset('backend/js/plugins.js') }}"></script>
    <script src="{{ asset('backend/js/main.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if(Session::has('message'))
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })
            
            Toast.fire({
                icon: '{{ Session::get("alert-type") }}',
                title: '{{ Session::get("message") }}'
            })
        @endif
    </script>
    {{-- PAGE-SPECIFIC JS — child views push here; jQuery and all globals are already loaded above --}}
    @stack('js')
</body>

</html>