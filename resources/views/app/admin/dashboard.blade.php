
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
            <style>
                .chart-empty-state {
                    min-height: 356px;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    text-align: center;
                    background: #fff;
                    border: 1px dashed #d9d9d9;
                    border-radius: 6px;
                    color: #555;
                    padding: 24px;
                }
                .chart-empty-state p {
                    margin: 0;
                    font-size: 16px;
                }
                .export-data-card {
                    background: linear-gradient(135deg, #0f172a 0%, #1e40af 55%, #2563eb 100%);
                    border-radius: 12px;
                    color: #fff;
                    padding: 22px 24px;
                    margin-bottom: 22px;
                    box-shadow: 0 10px 30px rgba(37, 99, 235, 0.28);
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                    gap: 20px;
                    flex-wrap: wrap;
                }
                .export-data-card h4 {
                    margin: 0 0 6px;
                    font-size: 18px;
                    font-weight: 700;
                }
                .export-data-card p {
                    margin: 0;
                    font-size: 13px;
                    opacity: 0.9;
                    max-width: 620px;
                    line-height: 1.6;
                }
                .export-data-card .export-tags {
                    margin-top: 10px;
                    display: flex;
                    flex-wrap: wrap;
                    gap: 6px;
                }
                .export-data-card .export-tag {
                    background: rgba(255,255,255,0.15);
                    border-radius: 20px;
                    padding: 3px 10px;
                    font-size: 11px;
                    font-weight: 600;
                }
                .btn-export-excel {
                    background: #fff;
                    color: #1e40af;
                    border: none;
                    border-radius: 8px;
                    padding: 12px 22px;
                    font-weight: 700;
                    font-size: 14px;
                    white-space: nowrap;
                    box-shadow: 0 4px 14px rgba(0,0,0,0.15);
                    transition: transform 0.15s ease, box-shadow 0.15s ease;
                    text-decoration: none;
                    display: inline-flex;
                    align-items: center;
                    gap: 8px;
                }
                .btn-export-excel:hover {
                    transform: translateY(-1px);
                    box-shadow: 0 6px 18px rgba(0,0,0,0.2);
                    color: #1e3a8a;
                    text-decoration: none;
                }
                .btn-export-excel i { color: #16a34a; font-size: 18px; }
            </style>
    @endpush
    <x-slot name="header"></x-slot>
    
    <div class="analytics-sparkle-area" style="margin-top: 20px">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="export-data-card">
                        <div>
                            <h4><i class="fa fa-file-text-o"></i> Export Complete School Data</h4>
                            <p>Download one CSV file with all school records — students, teachers, parents, fees, timetable, exams, book issues, and more. Each section is clearly labeled and opens directly in Excel.</p>
                            <div class="export-tags">
                                <span class="export-tag">Students</span>
                                <span class="export-tag">Teachers</span>
                                <span class="export-tag">Parents</span>
                                <span class="export-tag">Fees</span>
                                <span class="export-tag">Timetable</span>
                                <span class="export-tag">Exams</span>
                                <span class="export-tag">Book Issues</span>
                                <span class="export-tag">+ more</span>
                            </div>
                        </div>
                        <a href="{{ route('admin.export.school-data') }}" class="btn-export-excel" id="exportSchoolDataBtn">
                            <i class="fa fa-download"></i> Download CSV
                        </a>
                    </div>
                </div>
            </div>
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
                                        aria-valuemin="0" aria-valuemax="100" style="width:{{ $section > 0 ? ($numberOfStudent / $section) * 100 : 0 }}%"> 
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
                            <h2><span class="counter">{{ $numberOfTeachers }}</span> <span class="tuition-fees">Teaching Staff</span>
                            </h2>
                            <span class="text-danger">1 : {{ $studentTeacherRatio }} students</span>
                            <div class="progress m-b-0">
                                <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="50"
                                    aria-valuemin="0" aria-valuemax="100" style="width:{{ $numberOfStudent > 0 ? min(100, ($numberOfTeachers / $numberOfStudent) * 100) : 0 }}%;"> <span
                                        class="sr-only">Staff ratio</span> </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <div class="analytics-sparkle-line reso-mg-b-30">
                        <div class="analytics-content">
                            <h5>Collected Fees</h5>
                            <h2>PKR <span class="counter">{{ number_format($collectedFees, 0) }}</span> <span class="tuition-fees">Total Received</span>
                            </h2>
                            <span class="text-info">{{ $feeCollectionRate }}% collected</span>
                            <div class="progress m-b-0">
                                <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="50"
                                    aria-valuemin="0" aria-valuemax="100" style="width:{{ min(100, $feeCollectionRate) }}%;"> <span
                                        class="sr-only">{{ $feeCollectionRate }}% Complete</span> </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <div class="analytics-sparkle-line reso-mg-b-30">
                        <div class="analytics-content">
                            <h5>Paid Salaries</h5>
                            <h2>PKR <span class="counter">{{ number_format($paidSalaries, 0) }}</span> <span class="tuition-fees">Staff Payroll</span>
                            </h2>
                            <span class="text-inverse">Outstanding fees: PKR {{ number_format($outstandingFees, 0) }}</span>
                            <div class="progress m-b-0">
                                <div class="progress-bar progress-bar-inverse" role="progressbar" aria-valuenow="50"
                                    aria-valuemin="0" aria-valuemax="100" style="width:{{ $collectedFees > 0 ? min(100, ($paidSalaries / $collectedFees) * 100) : 0 }}%;"> <span
                                        class="sr-only">Payroll vs collection</span> </div>
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
                                        <p>Earnings Graph</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @php
                            $earnings = $earningsData ?? [];
                            $maxEarning = collect($earnings)->max() ?: 0;
                            $showEarningsChart = collect($earnings)->sum() > 0;
                        @endphp
                        @if ($showEarningsChart)
                            <ul class="list-inline cus-product-sl-rp">
                                <li>
                                    <h5><i class="fa fa-circle" style="color: #006DF0;"></i> Monthly Fee Collection (PKR)</h5>
                                </li>
                            </ul>
                            <div style="height: 356px; display:flex; align-items:flex-end; gap:18px; padding:20px 10px 0;">
                                @foreach ($earnings as $month => $amount)
                                    @php $barHeight = $maxEarning > 0 ? max(2, ($amount / $maxEarning) * 100) : 2; @endphp
                                    <div style="flex:1; display:flex; flex-direction:column; align-items:center; height:100%; justify-content:flex-end;">
                                        <span style="font-size:12px; font-weight:600; color:#444; margin-bottom:6px;">
                                            {{ $amount > 0 ? number_format($amount, 0) : '' }}
                                        </span>
                                        <div title="PKR {{ number_format($amount, 2) }}"
                                             style="width:60%; max-width:60px; height:{{ $barHeight }}%;
                                                    background:linear-gradient(180deg,#006DF0,#4aa3ff);
                                                    border-radius:4px 4px 0 0; transition:height .3s;"></div>
                                        <span style="font-size:12px; color:#888; margin-top:8px; white-space:nowrap;">{{ $month }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="chart-empty-state">
                                <div>
                                    <i class="fa fa-info-circle" style="font-size: 28px; margin-bottom: 10px; display: block;"></i>
                                    <p>No earnings data available yet.</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                    <div
                        class="white-box analytics-info-cs mg-b-10 res-mg-b-30 res-mg-t-30 table-mg-t-pro-n tb-sm-res-d-n dk-res-t-d-n">
                        <h3 class="box-title">Total Parents</h3>
                        <ul class="list-inline two-part-sp">
                            <li>
                                <div id="sparklinedash"></div>
                            </li>
                            <li class="text-right sp-cn-r"><i class="fa fa-users" aria-hidden="true"></i> <span
                                    class="counter text-success">{{ $numberOfParents }}</span></li>
                        </ul>
                    </div>
                    <div class="white-box analytics-info-cs mg-b-10 res-mg-b-30 tb-sm-res-d-n dk-res-t-d-n">
                        <h3 class="box-title">Total Classes</h3>
                        <ul class="list-inline two-part-sp">
                            <li>
                                <div id="sparklinedash2"></div>
                            </li>
                            <li class="text-right graph-two-ctn"><i class="fa fa-graduation-cap" aria-hidden="true"></i>
                                <span class="counter text-purple">{{ $totalClasses }}</span>
                            </li>
                        </ul>
                    </div>
                    <div class="white-box analytics-info-cs mg-b-10 res-mg-b-30 tb-sm-res-d-n dk-res-t-d-n">
                        <h3 class="box-title">Total Subjects</h3>
                        <ul class="list-inline two-part-sp">
                            <li>
                                <div id="sparklinedash3"></div>
                            </li>
                            <li class="text-right graph-three-ctn"><i class="fa fa-book" aria-hidden="true"></i>
                                <span class="counter text-info">{{ $totalSubjects }}</span>
                            </li>
                        </ul>
                    </div>
                    <div class="white-box analytics-info-cs table-dis-n-pro tb-sm-res-d-n dk-res-t-d-n">
                        <h3 class="box-title">Enrollment Rate</h3>
                        <ul class="list-inline two-part-sp">
                            <li>
                                <div id="sparklinedash4"></div>
                            </li>
                            <li class="text-right graph-four-ctn"><i class="fa fa-level-up"
                                    aria-hidden="true"></i> <span class="text-success"><span
                                        class="counter">{{ $enrollmentRate }}</span>%</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('js')
        <script>
            document.getElementById('exportSchoolDataBtn')?.addEventListener('click', function () {
                var btn = this;
                btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Preparing CSV export...';
                btn.style.pointerEvents = 'none';
                setTimeout(function () {
                    btn.innerHTML = '<i class="fa fa-download"></i> Download CSV';
                    btn.style.pointerEvents = '';
                }, 8000);
            });
        </script>
    @endpush
</x-tenant-app-layout>
