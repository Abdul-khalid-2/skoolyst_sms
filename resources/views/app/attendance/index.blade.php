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
        
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/echarts@5.4.3/dist/echarts.min.css">
    @endpush
    @push('css')

        <!-- Add any additional CSS needed for attendance -->
        {{-- <link rel="stylesheet" href="{{ asset('daterang') asset('backend/css/daterangepicker.css') }}"> --}}
    @endpush
    
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Attendance Management') }}
        </h2>
    </x-slot>


    <div class="analytics-sparkle-area" style="margin-top: 20px">
        <div class="container-fluid">
            <div class="row">
                <!-- Today's Attendance Summary -->
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <div class="analytics-sparkle-line reso-mg-b-30">
                        <div class="analytics-content">
                            <h5>Today's Attendance</h5>
                            <h2><span class="counter">{{ $stats['today']['percentage'] }}</span>% <span class="tuition-fees">Present Today</span></h2>
                            <span class="text-success">{{ $stats['today']['present'] }} present, {{ $stats['today']['absent'] }} absent</span>
                            <div class="progress m-b-0">
                                <div class="progress-bar progress-bar-success" role="progressbar" style="width:{{ $stats['today']['percentage'] }}%">
                                    <span class="sr-only">{{ $stats['today']['percentage'] }}% Complete</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Monthly Attendance -->
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <div class="analytics-sparkle-line reso-mg-b-30">
                        <div class="analytics-content">
                            <h5>Monthly Average</h5>
                            <h2><span class="counter">{{ $stats['monthly']['percentage'] }}</span>% <span class="tuition-fees">This Month</span></h2>
                            <span class="text-info">{{ $stats['monthly']['present'] }} present out of {{ $stats['monthly']['total_students'] }}</span>
                            <div class="progress m-b-0">
                                <div class="progress-bar progress-bar-info" role="progressbar" style="width:{{ $stats['monthly']['percentage'] }}%">
                                    <span class="sr-only">{{ $stats['monthly']['percentage'] }}% Complete</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Absent Students -->
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <div class="analytics-sparkle-line table-mg-t-pro dk-res-t-pro-30">
                        <div class="analytics-content">
                            <h5>Absent Today</h5>
                            <h2><span class="counter">{{ $stats['today']['absent'] }}</span> <span class="tuition-fees">Students</span></h2>
                            <span class="text-danger">{{ $stats['today']['late'] }} late arrivals</span>
                            <div class="progress m-b-0">

                                <div class="progress-bar progress-bar-danger" role="progressbar" style="width:{{ $stats['today']['absent_percentage'] }}%">
                                    <span class="sr-only">{{ $stats['today']['absent_percentage'] }}% Absent</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Teacher Attendance -->
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <div class="analytics-sparkle-line table-mg-t-pro dk-res-t-pro-30">
                        <div class="analytics-content">
                            <h5>Teacher Attendance</h5>
                            <h2><span class="counter">{{ $stats['teachers']['percentage'] }}</span>% <span class="tuition-fees">Present Today</span></h2>
                            <span class="text-warning">{{ $stats['teachers']['absent'] }} Teachers Absent</span>
                            <div class="progress m-b-0">
                                <div class="progress-bar progress-bar-warning" role="progressbar" style="width:{{ $stats['teachers']['percentage'] }}%">
                                    <span class="sr-only">{{ $stats['teachers']['percentage'] }}% Complete</span>
                                </div>
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
                <!-- Main Attendance Chart -->
                <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                    <div class="product-sales-chart">
                        <div class="portlet-title">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <div class="caption pro-sl-hd">
                                        <span class="caption-subject"><b>Attendance Trends</b></span>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <div class="actions graph-rp">
                                        <div class="btn-group" data-toggle="buttons">
                                            <label class="btn btn-sm btn-primary active">
                                                <input type="radio" name="options" id="option1" autocomplete="off" checked> Daily
                                            </label>
                                            <label class="btn btn-sm btn-primary">
                                                <input type="radio" name="options" id="option2" autocomplete="off"> Weekly
                                            </label>
                                            <label class="btn btn-sm btn-primary">
                                                <input type="radio" name="options" id="option3" autocomplete="off"> Monthly
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <ul class="list-inline cus-product-sl-rp">
                            <li><h5><i class="fa fa-circle" style="color: #006DF0;"></i>Present</h5></li>
                            <li><h5><i class="fa fa-circle" style="color: #933EC5;"></i>Absent</h5></li>
                            <li><h5><i class="fa fa-circle" style="color: #65b12d;"></i>Late</h5></li>
                        </ul>
                        <div id="attendance-trend-chart" style="height: 356px;"></div>
                    </div>
                </div>
                
                <!-- Quick Actions -->
                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                    <div class="white-box analytics-info-cs">
                        <h3 class="box-title">Quick Actions</h3>
                        <div class="quick-action-buttons">
                            <a href="{{ route('admin.attendance.create') }}" class="btn btn-primary btn-block mg-b-10">
                                <i class="fa fa-calendar-check-o fa-lg"></i> Take Today's Attendance
                            </a>
                            <a href="#" class="btn btn-success btn-block mg-b-10">
                                <i class="fa fa-file-text-o fa-lg"></i> Generate Monthly Report
                            </a>
                            <a href="#" class="btn btn-info btn-block mg-b-10">
                                <i class="fa fa-search fa-lg"></i> View Attendance History
                            </a>
                            <a href="#" class="btn btn-warning btn-block">
                                <i class="fa fa-bell-o fa-lg"></i> Send Absence Notices
                            </a>
                        </div>
                        
                        <h3 class="box-title mg-t-20">Lowest Attendance Classes</h3>
                        <div class="list-group">
                            @foreach($lowestClasses as $class)
                            <a href="#" class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1">{{ $class['class'] }} - Section {{ $class['section'] }}</h5>
                                    <small class="{{ $class['percentage'] < 75 ? 'text-danger' : ($class['percentage'] < 85 ? 'text-warning' : 'text-success') }}">{{ $class['percentage'] }}%</small>
                                </div>
                                <p class="mb-1">{{ $class['absent'] }} absent today</p>
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Attendance Records -->

    <div class="data-table-area mg-tb-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline13-list">
                        <div class="sparkline13-hd">
                            <div class="main-sparkline13-hd">
                                <h1>Recent Attendance Records</h1>
                            </div>
                        </div>
                        <div class="sparkline13-graph">
                            <div class="datatable-dashv1-list custom-datatable-overright">
                                <div class="table-responsive">
                                    <table id="recent-attendance-table" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Class</th>
                                                <th>Section</th>
                                                <th>Present</th>
                                                <th>Absent</th>
                                                <th>Late</th>
                                                <th>Percentage</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($recentRecords as $record)
                                                <tr>
                                                    <td>{{ $record['date'] }}</td>
                                                    <td>{{ $record['class'] }}</td>
                                                    <td>{{ $record['section'] }}</td>
                                                    <td>{{ $record['present'] }}</td>
                                                    <td>{{ $record['absent'] }}</td>
                                                    <td>{{ $record['late'] }}</td>
                                                    <td class="{{ $record['percentage'] < 75 ? 'text-danger' : ($record['percentage'] < 85 ? 'text-warning' : 'text-success') }}">{{ $record['percentage'] }}%</td>
                                                    <td>
                                                        <button class="btn btn-primary btn-xs">View</button>
                                                        <button class="btn btn-warning btn-xs">Edit</button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

    <!-- Calendar Section -->
    <div class="calendar-area mg-tb-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="calendar-widget">
                        <div class="cal-head">
                            <h2>Attendance Calendar</h2>

                        </div>
                        <div id="attendance-calendar"></div>
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
        <script src="https://cdn.jsdelivr.net/npm/echarts@5.4.3/dist/echarts.min.js"></script>
    @endpush
    @push('js')

        <script>
            $(document).ready(function() {
                // Initialize attendance calendar
                $('#attendance-calendar').fullCalendar({
                    header: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'month,agendaWeek,agendaDay'
                    },
                    defaultDate: moment().format('YYYY-MM-DD'),
                    editable: false,
                    eventLimit: true,

                    events: @json($calendarEvents),
                    dayRender: function(date, cell) {
                        // Highlight weekends
                        if (date.day() === 0 || date.day() === 6) {
                            cell.css('background-color', '#f9f9f9');
                        }
                    }
                });
                
                // Initialize data table
                $('#recent-attendance-table').DataTable({
                    dom: 'lfrtip',
                    pageLength: 5,
                    ordering: false
                });

                $('input[name="options"]').change(function() {
                    let period = $(this).attr('id').replace('option', '');
                    updateChart(period);
                });

                function updateChart(period) {
                    // AJAX call to get data for selected period
                    $.get('/attendance/trends?period=' + period, function(data) {
                        // Update the chart with new data
                        attendanceChart.setOption({
                            xAxis: { data: data.days },
                            series: [
                                { data: data.present },
                                { data: data.absent },
                                { data: data.late }
                            ]
                        });
                    });
                }
            });

            // Initialize the attendance trends chart
            var attendanceChart = echarts.init(document.getElementById('attendance-trend-chart'));

            // Default options
            var option = {
                tooltip: {
                    trigger: 'axis',
                    formatter: function(params) {
                        var result = params[0].axisValue + '<br/>';
                        params.forEach(function(item) {
                            result += item.marker + ' ' + item.seriesName + ': ' + item.value + '<br/>';
                        });
                        return result;
                    }
                },
                legend: {
                    data: ['Present', 'Absent', 'Late']
                },
                grid: {
                    left: '3%',
                    right: '4%',
                    bottom: '3%',
                    containLabel: true
                },
                xAxis: {
                    type: 'category',
                    boundaryGap: false,
                    data: @json($attendanceTrends['days'])
                },
                yAxis: {
                    type: 'value',
                    min: 0,
                    axisLabel: {
                        formatter: '{value}'
                    }
                },
                series: [
                    {
                        name: 'Present',
                        type: 'line',
                        smooth: true,
                        data: @json($attendanceTrends['present']),
                        itemStyle: { color: '#006DF0' },
                        areaStyle: {
                            color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [
                                { offset: 0, color: 'rgba(0, 109, 240, 0.3)' },
                                { offset: 1, color: 'rgba(0, 109, 240, 0.1)' }
                            ])
                        }
                    },
                    {
                        name: 'Absent',
                        type: 'line',
                        smooth: true,
                        data: @json($attendanceTrends['absent']),
                        itemStyle: { color: '#933EC5' },
                        areaStyle: {
                            color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [
                                { offset: 0, color: 'rgba(147, 62, 197, 0.3)' },
                                { offset: 1, color: 'rgba(147, 62, 197, 0.1)' }
                            ])
                        }
                    },
                    {
                        name: 'Late',
                        type: 'line',
                        smooth: true,
                        data: @json($attendanceTrends['late']),
                        itemStyle: { color: '#65b12d' },
                        areaStyle: {
                            color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [
                                { offset: 0, color: 'rgba(101, 177, 45, 0.3)' },
                                { offset: 1, color: 'rgba(101, 177, 45, 0.1)' }
                            ])
                        }
                    }
                ]
            };

            // Apply the chart options
            attendanceChart.setOption(option);

            // Handle window resize
            window.addEventListener('resize', function() {
                attendanceChart.resize();
            });

            // Period toggle functionality
            $('input[name="options"]').change(function() {
                let period = $(this).attr('id').replace('option', '');
                let periodText = $(this).parent().text().trim().toLowerCase();
                
                updateChart(periodText);
            });

            function updateChart(period) {
                // Show loading effect
                attendanceChart.showLoading();
                
                // AJAX call to get data for selected period
                $.get('/attendance/trends?period=' + period, function(data) {
                    // Update the chart with new data
                    attendanceChart.setOption({
                        xAxis: { data: data.days },
                        series: [
                            { data: data.present },
                            { data: data.absent },
                            { data: data.late }
                        ]
                    });
                    
                    // Hide loading effect
                    attendanceChart.hideLoading();
                }).fail(function() {
                    attendanceChart.hideLoading();
                    console.error('Failed to load attendance trends data');
                });
            }
            attendanceChart.setOption(option);
        </script>
    @endpush
</x-tenant-app-layout>