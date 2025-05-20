
<x-tenant-app-layout>
    @push('css')
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
    @endpush
    <x-slot name="header"></x-slot>
    
    <div class="analytics-sparkle-area" style="margin-top: 20px">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <div class="analytics-sparkle-line reso-mg-b-30">
                        <div class="analytics-content">
                            <h5>Total Students</h5>
                            <h2><span class="counter">{{ $numberOfStudent }}</span> <span class="tuition-fees">Current Inrolled</span>
                            </h2>
                            <span class="text-success">
                                @if($section != 0)
                                    {{ number_format(($numberOfStudent / $section) * 100, 2) }}%
                                @else
                                    0%
                                @endif
                            </span>
                            
                            @if ($numberOfStudent == 0)
                                <div class="progress m-b-0">
                                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="50"
                                        aria-valuemin="0" aria-valuemax="100" style="width:0%"> 
                                        <span
                                            class="sr-only">20% Complete
                                        </span> 
                                    </div>
                                </div>
                            @else
                                <div class="progress m-b-0">
                                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="50"
                                        aria-valuemin="0" aria-valuemax="100" style="width:{{ ($numberOfStudent / $section) * 100 }}%"> 
                                        <span
                                            class="sr-only">20% Complete
                                        </span> 
                                    </div>
                                </div>                                
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <div class="analytics-sparkle-line reso-mg-b-30">
                        <div class="analytics-content">
                            <h5>Total Teachers</h5>
                            <h2><span class="counter">{{ $numberOfTeachers }}</span> <span class="tuition-fees">Current Inrolled</span>
                            </h2>
                            <span class="text-danger">{{ number_format(($numberOfTeachers / 15) * 100, 2) }}%</span>
                            <div class="progress m-b-0">
                                <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="50"
                                    aria-valuemin="0" aria-valuemax="100" style="width:{{ ($numberOfTeachers / 15) * 100 }}%;"> <span
                                        class="sr-only">230% Complete</span> </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <div class="analytics-sparkle-line reso-mg-b-30 table-mg-t-pro dk-res-t-pro-30">
                        <div class="analytics-content">
                            <h5>Collected Fees</h5>
                            <h2>$<span class="counter">2000</span> <span class="tuition-fees">Tuition Fees</span>
                            </h2>
                            <span class="text-info">60%</span>
                            <div class="progress m-b-0">
                                <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="50"
                                    aria-valuemin="0" aria-valuemax="100" style="width:60%;"> <span
                                        class="sr-only">20% Complete</span> </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <div class="analytics-sparkle-line table-mg-t-pro dk-res-t-pro-30">
                        <div class="analytics-content">
                            <h5>Payed Salaries</h5>
                            <h2>$<span class="counter">3500</span> <span class="tuition-fees">Tuition Fees</span>
                            </h2>
                            <span class="text-inverse">80%</span>
                            <div class="progress m-b-0">
                                <div class="progress-bar progress-bar-inverse" role="progressbar" aria-valuenow="50"
                                    aria-valuemin="0" aria-valuemax="100" style="width:80%;"> <span
                                        class="sr-only">230% Complete</span> </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="product-sales-area mg-tb-30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12">
                    <div class="product-sales-chart">
                        <div class="portlet-title">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <div class="caption pro-sl-hd">
                                        <span class="caption-subject"><b>School Earnings</b></span>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <div class="actions graph-rp graph-rp-dl">
                                        <p>All Earnings are in million $</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <ul class="list-inline cus-product-sl-rp">
                            <li>
                                <h5><i class="fa fa-circle" style="color: #006DF0;"></i>CSE</h5>
                            </li>
                            <li>
                                <h5><i class="fa fa-circle" style="color: #933EC5;"></i>Accounting</h5>
                            </li>
                            <li>
                                <h5><i class="fa fa-circle" style="color: #65b12d;"></i>Electrical</h5>
                            </li>
                        </ul>
                        <div id="extra-area-chart" style="height: 356px;"></div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                    <div
                        class="white-box analytics-info-cs mg-b-10 res-mg-b-30 res-mg-t-30 table-mg-t-pro-n tb-sm-res-d-n dk-res-t-d-n">
                        <h3 class="box-title">Total Visit</h3>
                        <ul class="list-inline two-part-sp">
                            <li>
                                <div id="sparklinedash"></div>
                            </li>
                            <li class="text-right sp-cn-r"><i class="fa fa-level-up" aria-hidden="true"></i> <span
                                    class="counter text-success">1500</span></li>
                        </ul>
                    </div>
                    <div class="white-box analytics-info-cs mg-b-10 res-mg-b-30 tb-sm-res-d-n dk-res-t-d-n">
                        <h3 class="box-title">Page Views</h3>
                        <ul class="list-inline two-part-sp">
                            <li>
                                <div id="sparklinedash2"></div>
                            </li>
                            <li class="text-right graph-two-ctn"><i class="fa fa-level-up" aria-hidden="true"></i>
                                <span class="counter text-purple">3000</span>
                            </li>
                        </ul>
                    </div>
                    <div class="white-box analytics-info-cs mg-b-10 res-mg-b-30 tb-sm-res-d-n dk-res-t-d-n">
                        <h3 class="box-title">Unique Visitor</h3>
                        <ul class="list-inline two-part-sp">
                            <li>
                                <div id="sparklinedash3"></div>
                            </li>
                            <li class="text-right graph-three-ctn"><i class="fa fa-level-up" aria-hidden="true"></i>
                                <span class="counter text-info">5000</span>
                            </li>
                        </ul>
                    </div>
                    <div class="white-box analytics-info-cs table-dis-n-pro tb-sm-res-d-n dk-res-t-d-n">
                        <h3 class="box-title">Bounce Rate</h3>
                        <ul class="list-inline two-part-sp">
                            <li>
                                <div id="sparklinedash4"></div>
                            </li>
                            <li class="text-right graph-four-ctn"><i class="fa fa-level-down"
                                    aria-hidden="true"></i> <span class="text-danger"><span
                                        class="counter">18</span>%</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('js')
        
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
    <!-- ---------------------------------------- -->
    @endpush
</x-tenant-app-layout>
