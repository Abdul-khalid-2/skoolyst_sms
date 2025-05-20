
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
                        @if($invormentdata->logo)
                            <a href="index.html">
                                <img class="main-logo" height="8px" src="{{ asset('tenancy/assets/' . $invormentdata->logo) }}" alt="{{ $invormentdata->name }} Logo"/>
                            </a>                                
                        @else
                            <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"></path>
                            </svg>
                        @endif
                        <span class="ml-2 text-2xl font-bold text-gray-800">{{ $invormentdata->name??"school" }}</span>
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

    @stack('js')
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
</body>

</html>