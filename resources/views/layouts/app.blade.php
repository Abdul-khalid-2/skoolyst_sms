{{-- <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @stack('css')
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html> --}}



{{-- <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @stack('css')
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('app.layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html> --}}

<!doctype html>
<html class="no-js" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Dashboard V.1 | Kiaalap - Kiaalap Admin Template</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- favicon
============================================ -->
      <link rel="shortcut icon" type="image/x-icon" href="tenancy/assets/backend/img/favicon.ico">
      <!-- Google Fonts
          ============================================ -->
      <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,700,900" rel="stylesheet">
      <!-- Bootstrap CSS
          ============================================ -->
      <link rel="stylesheet" href=" {{ asset('backend/css/bootstrap.min.css') }} ">
      <!-- Bootstrap CSS
          ============================================ -->
      <link rel="stylesheet" href=" {{ asset('backend/css/font-awesome.min.css') }} ">
      <!-- owl.carousel CSS
          ============================================ -->
      <link rel="stylesheet" href=" {{ asset('backend/css/owl.carousel.css') }} ">
      <link rel="stylesheet" href=" {{ asset('backend/css/owl.theme.css') }} ">
      <link rel="stylesheet" href=" {{ asset('backend/css/owl.transitions.css') }} ">
      <!-- animate CSS
          ============================================ -->
      <link rel="stylesheet" href=" {{ asset('backend/css/animate.css') }} ">
      <!-- normalize CSS
          ============================================ -->
      <link rel="stylesheet" href=" {{ asset('backend/css/normalize.css') }} ">
      <!-- meanmenu icon CSS
          ============================================ -->
      <link rel="stylesheet" href=" {{ asset('backend/css/meanmenu.min.css') }} ">
      <!-- main CSS
          ============================================ -->
      <link rel="stylesheet" href=" {{ asset('backend/css/main.css') }} ">
      <!-- educate icon CSS
          ============================================ -->
      <link rel="stylesheet" href="{{ asset('backend/css/educate-custon-icon.css') }}">
      <!-- morrisjs CSS
          ============================================ -->
      <link rel="stylesheet" href=" {{ asset('backend/css/morrisjs/morris.css') }} ">
      <!-- mCustomScrollbar CSS
          ============================================ -->
      <link rel="stylesheet" href=" {{ asset('backend/css/scrollbar/jquery.mCustomScrollbar.min.css') }} ">
      <!-- metisMenu CSS
          ============================================ -->
      <link rel="stylesheet" href=" {{ asset('backend/css/metisMenu/metisMenu.min.css') }} ">
      <link rel="stylesheet" href=" {{ asset('backend/css/metisMenu/metisMenu-vertical.css') }} ">
      <!-- calendar CSS
          ============================================ -->
      <link rel="stylesheet" href=" {{ asset('backend/css/calendar/fullcalendar.min.css') }} ">
      <link rel="stylesheet" href=" {{ asset('backend/css/calendar/fullcalendar.print.min.css') }} ">
      <!-- style CSS
          ============================================ -->
      <link rel="stylesheet" href="{{ asset('backend/style.css') }} ">
      <!-- responsive CSS
          ============================================ -->
      <link rel="stylesheet" href=" {{ asset('backend/css/responsive.css') }} ">
      <!-- modernizr JS
          ============================================ -->
      <script src=" {{ asset('backend/js/vendor/modernizr-2.8.3.min.js') }}"></script>
</head>

<body>


    <!-- ---------------------------------------- -->
    <!--[if lt IE 8]>
		<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
	<![endif]-->
     <!-- Start Left menu area -->
     <div class="left-sidebar-pro">

        @include('layouts.sidebar')
    </div>
    <!-- End Left menu area -->
    <!-- Start Welcome area -->
    <div class="all-content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 20px">
                    <div class="logo-pro">
                        <a href="index.html"><img class="main-logo" src="tenancy/assets/backend/img/logo/logo.png" alt="" /></a>
                    </div>
                </div>
            </div>
        </div>

        {{-- header navigation code is here  --}}
        @include('layouts.navigation')
        
        {{ $slot }}
        
    </div>

    <!-- jquery
		============================================ -->
    <script src=" {{ asset('backend/js/vendor/jquery-1.12.4.min.js') }}"></script>
    <!-- bootstrap JS
		============================================ -->
    <script src=" {{ asset('backend/js/bootstrap.min.js') }}"></script>
    <!-- wow JS
		============================================ -->
    <script src=" {{ asset('backend/js/wow.min.js') }}"></script>
    <!-- price-slider JS
		============================================ -->
    <script src=" {{ asset('backend/js/jquery-price-slider.js') }}"></script>
    <!-- meanmenu JS
		============================================ -->
    <script src=" {{ asset('backend/js/jquery.meanmenu.js') }}"></script>
    <!-- owl.carousel JS
		============================================ -->
    <script src=" {{ asset('backend/js/owl.carousel.min.js') }}"></script>
    <!-- sticky JS
		============================================ -->
    <script src=" {{ asset('backend/js/jquery.sticky.js') }}"></script>
    <!-- scrollUp JS
		============================================ -->
    <script src=" {{ asset('backend/js/jquery.scrollUp.min.js') }}"></script>
    <!-- counterup JS
		============================================ -->
    <script src=" {{ asset('backend/js/counterup/jquery.counterup.min.js') }}"></script>
    <script src=" {{ asset('backend/js/counterup/waypoints.min.js') }}"></script>
    <script src=" {{ asset('backend/js/counterup/counterup-active.js') }}"></script>
    <!-- mCustomScrollbar JS
		============================================ -->
    <script src=" {{ asset('backend/js/scrollbar/jquery.mCustomScrollbar.concat.min.js') }}"></script>
    <script src=" {{ asset('backend/js/scrollbar/mCustomScrollbar-active.js') }}"></script>
    <!-- metisMenu JS
		============================================ -->
    <script src=" {{ asset('backend/js/metisMenu/metisMenu.min.js') }}"></script>
    <script src=" {{ asset('backend/js/metisMenu/metisMenu-active.js') }}"></script>
    <!-- morrisjs JS
		============================================ -->
    <script src=" {{ asset('backend/js/morrisjs/raphael-min.js') }}"></script>
    {{-- <script src=" {{ asset('backend/js/morrisjs/morris.js') }}"></script> --}}
    {{-- <script src=" {{ asset('backend/js/morrisjs/morris-active.js') }}"></script> --}}
    <!-- morrisjs JS
		============================================ -->
    <script src=" {{ asset('backend/js/sparkline/jquery.sparkline.min.js') }}"></script>
    <script src=" {{ asset('backend/js/sparkline/jquery.charts-sparkline.js') }}"></script>
    <script src=" {{ asset('backend/js/sparkline/sparkline-active.js') }}"></script>
    <!-- calendar JS
		============================================ -->
    <script src=" {{ asset('backend/js/calendar/moment.min.js') }}"></script>
    <script src=" {{ asset('backend/js/calendar/fullcalendar.min.js') }}"></script>
    <script src=" {{ asset('backend/js/calendar/fullcalendar-active.js') }}"></script>
    <!-- plugins JS
		============================================ -->
    <script src=" {{ asset('backend/js/plugins.js') }}"></script>
    <!-- main JS
		============================================ -->
    <script src=" {{ asset('backend/js/main.js') }}"></script>
    <!-- tawk chat JS
		============================================ -->
    {{-- <!-- <script src=" {{ asset('backend/js/tawk-chat.js') }}"></script> --> --}}
</body>

</html>