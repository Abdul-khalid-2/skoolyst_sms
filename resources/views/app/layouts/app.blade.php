
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
        .dropdown-container {
            position: relative;
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

        .dropdown-menu-custom.open {
            display: block;
        }

        /* ── Page header sub-nav: buttons on desktop, 3-dot menu on mobile ── */
        .page-header-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 8px 0;
            gap: 10px;
        }

        .page-header-title {
            margin: 0;
            flex: 1;
            min-width: 0;
        }

        .page-header-actions {
            flex-shrink: 0;
        }

        @media (min-width: 768px) {
            .page-header-actions {
                position: static;
            }

            .page-header-actions .dropdown-toggle-custom {
                display: none !important;
            }

            .page-header-actions .page-header-dropdown-menu {
                display: flex !important;
                flex-wrap: wrap;
                justify-content: flex-end;
                gap: 6px;
                position: static;
                top: auto;
                left: auto;
                right: auto;
                background: transparent;
                border: none;
                box-shadow: none;
                min-width: 0;
                padding: 0;
            }

            .page-header-actions .page-header-dropdown-menu a {
                display: inline-block;
                padding: 5px 12px;
                border: 1px solid #ccc;
                border-radius: 3px;
                background: #fff;
                font-size: 13px;
                line-height: 1.42857143;
                white-space: nowrap;
                border-bottom: 1px solid #ccc;
            }

            .page-header-actions .page-header-dropdown-menu a:hover {
                background: #f5f5f5;
                text-decoration: none;
            }
        }

        @media (max-width: 767px) {
            .page-header-actions .page-header-dropdown-menu {
                left: auto;
                right: 0;
            }

            /* Legacy breadcome headers: show 3-dot menu, hide inline buttons */
            .breadcome-list .action-buttons {
                display: none;
            }
        }

        @media (min-width: 768px) {
            /* Legacy breadcome headers: show inline buttons, hide 3-dot menu */
            .breadcome-list .action-buttons + .dropdown-container .dropdown-toggle-custom {
                display: none !important;
            }

            .breadcome-list .action-buttons + .dropdown-container .dropdown-menu-custom {
                display: none !important;
            }
        }

        /* ── Mobile layout fixes ─────────────────────────────── */
        @media (max-width: 767px) {
            /* Prevent horizontal scroll */
            html, body {
                overflow-x: hidden;
                width: 100%;
            }

            /* Hide desktop sidebar — mobile-menu-area in navigation handles nav */
            .left-sidebar-pro {
                display: none !important;
            }

            /* Content fills full width with no left margin */
            .all-content-wrapper {
                margin-left: 0 !important;
                width: 100% !important;
            }

            /* Make blue header cover full width */
            .header-top-area {
                left: 0 !important;
                width: 100% !important;
            }

            /* Header top row: stack vertically */
            .header-top-area .row > [class*="col-"] {
                width: 100%;
            }

            /* Prevent tables from blowing out the viewport */
            .table-responsive {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }

            /* Cards and sparkline boxes: full width */
            .analytics-sparkle-line,
            .sparkline13-list,
            .sparkline12-list,
            .white-box {
                margin-bottom: 15px;
            }

            /* Nav tabs: allow horizontal scroll on very small screens */
            .nav-tabs {
                white-space: nowrap;
                overflow-x: auto;
                overflow-y: hidden;
                -webkit-overflow-scrolling: touch;
                display: flex;
                flex-wrap: nowrap;
            }
            .nav-tabs > li {
                float: none;
                display: inline-block;
            }

            /* Logo area */
            .logo-pro {
                padding: 10px 0;
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
    <script>
        $(document).ready(function () {
            $(document).on('click', '.dropdown-toggle-custom', function (e) {
                e.stopPropagation();
                var $menu = $(this).next('.dropdown-menu-custom');
                $('.dropdown-menu-custom').not($menu).removeClass('open');
                $menu.toggleClass('open');
            });
            $(document).on('click', function () {
                $('.dropdown-menu-custom').removeClass('open');
            });
        });
    </script>
    {{-- PAGE-SPECIFIC JS — child views push here; jQuery and all globals are already loaded above --}}
    @stack('js')
</body>

</html>