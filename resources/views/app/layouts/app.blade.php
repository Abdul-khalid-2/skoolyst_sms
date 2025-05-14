
<!doctype html>
<html class="no-js" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{ isset($invormentdata->name) ? $invormentdata->name : 'Schoo Management System'  }}</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('backend/img/favicon.ico') }}">
    @stack('css')
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
                        <a href="index.html"><img class="main-logo" src="{{ asset('backend/img/logo/logo.png') }}" alt="" /></a>
                    </div>
                </div>
            </div>
        </div>

        {{-- header navigation code is here  --}}
        
        
        @isset($header)
            @include('app.layouts.navigation')
        @endisset

        {{ $slot }}

        {{-- <div class="footer-copyright-area">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="footer-copy-right">
                            <p>Copyright © 2025. All rights reserved. Template by Abudl Khalid</p>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>

    @stack('js')
</body>

</html>