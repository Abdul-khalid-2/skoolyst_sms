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
        <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">

        <style>
            .settings-card {
                border-radius: 5px;
                padding: 20px;
                margin-bottom: 20px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
                background: #fff;
            }

            .settings-card h4 {
                border-bottom: 1px solid #eee;
                padding-bottom: 10px;
                margin-bottom: 20px;
            }

            .settings-group {
                margin-bottom: 15px;
            }

            .settings-label {
                font-weight: 600;
                margin-bottom: 5px;
            }
        </style>
    @endpush

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('School Settings') }}
        </h2>
    </x-slot>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="breadcome-list">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="breadcome-heading" style="margin-top: 10px">
                                <h3>School Setting</h3>
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
                    <div class="sparkline12-hd">
                        <div class="main-sparkline12-hd">
                            <h1>School Profile</h1>
                        </div>
                    </div>
                    <div class="sparkline12-graph">
                        <div class="basic-login-form-ad">
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    <div class="settings-menu">
                                        <ul class="nav nav-tabs tabs-left">
                                            <li class="active"><a href="#general" data-toggle="tab"><i class="fa fa-cog"></i> General Settings</a></li>
                                            <li><a href="#academic" data-toggle="tab"><i class="fa fa-graduation-cap"></i> Academic Settings</a></li>
                                            <li><a href="#attendance" data-toggle="tab"><i class="fa fa-calendar-check"></i> Attendance Settings</a></li>
                                            <li><a href="#fee" data-toggle="tab"><i class="fa fa-money-bill-wave"></i> Fee Settings</a></li>
                                            <li><a href="#notifications" data-toggle="tab"><i class="fa fa-bell"></i> Notifications</a></li>
                                            <li><a href="#security" data-toggle="tab"><i class="fa fa-shield-alt"></i> Security</a></li>
                                        </ul>
                                    </div>
                                </div>
    
                                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="general">
                                            <form action="{{ route('schools.update-settings') }}" method="POST">
                                                @csrf
                                                @method('PUT')
    
                                                <div class="settings-card">
                                                    <h4>Basic Information</h4>
    
                                                    <div class="settings-group">
                                                        <label class="settings-label">Time Zone</label>
                                                        <select name="timezone" class="form-control" required>
                                                            @foreach(timezone_identifiers_list() as $tz)
                                                            <option value="{{ $tz }}" {{ ($settings['timezone'] ?? 'UTC') == $tz ? 'selected' : '' }}>
                                                                {{ $tz }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
    
                                                    <div class="settings-group">
                                                        <label class="settings-label">Date Format</label>
                                                        <select name="date_format" class="form-control" required>
                                                            <option value="d/m/Y" {{ ($settings['date_format'] ?? 'd/m/Y') == 'd/m/Y' ? 'selected' : '' }}>
                                                                DD/MM/YYYY</option>
                                                            <option value="m/d/Y" {{ ($settings['date_format'] ?? 'd/m/Y') == 'm/d/Y' ? 'selected' : '' }}>
                                                                MM/DD/YYYY</option>
                                                            <option value="Y-m-d" {{ ($settings['date_format'] ?? 'd/m/Y') == 'Y-m-d' ? 'selected' : '' }}>
                                                                YYYY-MM-DD</option>
                                                        </select>
                                                    </div>
                                                </div>
    
                                                <div class="text-right">
                                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                                </div>
                                            </form>
                                        </div>
    
                                        <div class="tab-pane" id="academic">
                                            <form action="{{ route('schools.update-academic-settings') }}" method="POST">
                                                @csrf
                                                @method('PUT')
    
                                                <div class="settings-card">
                                                    <h4>Academic Configuration</h4>
    
                                                    <div class="settings-group">
                                                        <label>Working Hours</label>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label class="small">From Time</label>
                                                                <input type="time" name="working_hours_start" class="form-control @error('working_hours_start') is-invalid @enderror" value="{{ old('working_hours_start', $settings['working_hours_start'] ?? '08:00') }}">
                                                                @error('working_hours_start')
                                                                <div class="invalid-feedback" style="color: red">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="small">To Time</label>
                                                                <input type="time" name="working_hours_end" class="form-control @error('working_hours_end') is-invalid @enderror" value="{{ old('working_hours_end', $settings['working_hours_end'] ?? '15:00') }}">
                                                                @error('working_hours_end')
                                                                <div class="invalid-feedback" style="color: red">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
    
                                                    <div class="settings-group">
                                                        <label>Working Days</label>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label class="small">From Day</label>
                                                                <select name="working_days_start" class="form-control @error('working_days_start') is-invalid @enderror">
                                                                    <option value="Monday" {{ old('working_days_start', $settings['working_days_start'] ?? 'Monday') == 'Monday' ? 'selected' : '' }}>
                                                                        Monday</option>
                                                                    <option value="Tuesday" {{ old('working_days_start', $settings['working_days_start'] ?? 'Monday') == 'Tuesday' ? 'selected' : '' }}>
                                                                        Tuesday</option>
                                                                    <option value="Wednesday" {{ old('working_days_start', $settings['working_days_start'] ?? 'Monday') == 'Wednesday' ? 'selected' : '' }}>
                                                                        Wednesday</option>
                                                                    <option value="Thursday" {{ old('working_days_start', $settings['working_days_start'] ?? 'Monday') == 'Thursday' ? 'selected' : '' }}>
                                                                        Thursday</option>
                                                                    <option value="Friday" {{ old('working_days_start', $settings['working_days_start'] ?? 'Monday') == 'Friday' ? 'selected' : '' }}>
                                                                        Friday</option>
                                                                    <option value="Saturday" {{ old('working_days_start', $settings['working_days_start'] ?? 'Monday') == 'Saturday' ? 'selected' : '' }}>
                                                                        Saturday</option>
                                                                    <option value="Sunday" {{ old('working_days_start', $settings['working_days_start'] ?? 'Monday') == 'Sunday' ? 'selected' : '' }}>
                                                                        Sunday</option>
                                                                </select>
                                                                @error('working_days_start')
                                                                <div class="invalid-feedback" style="color: red">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="small">To Day</label>
                                                                <select name="working_days_end" class="form-control @error('working_days_end') is-invalid @enderror">
                                                                    <option value="Monday" {{ old('working_days_end', $settings['working_days_end'] ?? 'Friday') == 'Monday' ? 'selected' : '' }}>
                                                                        Monday</option>
                                                                    <option value="Tuesday" {{ old('working_days_end', $settings['working_days_end'] ?? 'Friday') == 'Tuesday' ? 'selected' : '' }}>
                                                                        Tuesday</option>
                                                                    <option value="Wednesday" {{ old('working_days_end', $settings['working_days_end'] ?? 'Friday') == 'Wednesday' ? 'selected' : '' }}>
                                                                        Wednesday</option>
                                                                    <option value="Thursday" {{ old('working_days_end', $settings['working_days_end'] ?? 'Friday') == 'Thursday' ? 'selected' : '' }}>
                                                                        Thursday</option>
                                                                    <option value="Friday" {{ old('working_days_end', $settings['working_days_end'] ?? 'Friday') == 'Friday' ? 'selected' : '' }}>
                                                                        Friday</option>
                                                                    <option value="Saturday" {{ old('working_days_end', $settings['working_days_end'] ?? 'Friday') == 'Saturday' ? 'selected' : '' }}>
                                                                        Saturday</option>
                                                                    <option value="Sunday" {{ old('working_days_end', $settings['working_days_end'] ?? 'Friday') == 'Sunday' ? 'selected' : '' }}>
                                                                        Sunday</option>
                                                                </select>
                                                                @error('working_days_end')
                                                                <div class="invalid-feedback" style="color: red">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
    
                                                    <div class="settings-group">
                                                        <label class="settings-label">Grading System</label>
                                                        <select name="grading_system" class="form-control" required>
                                                            <option value="percentage" {{ ($settings['grading_system'] ?? 'percentage') == 'percentage' ? 'selected' : '' }}>
                                                                Percentage</option>
                                                            <option value="letter" {{ ($settings['grading_system'] ?? 'percentage') == 'letter' ? 'selected' : '' }}>
                                                                Letter Grades</option>
                                                            <option value="gpa" {{ ($settings['grading_system'] ?? 'percentage') == 'gpa' ? 'selected' : '' }}>
                                                                GPA Scale</option>
                                                        </select>
                                                    </div>
    
                                                    <div class="settings-group">
                                                        <label class="settings-label">Default Class Capacity</label>
                                                        <input type="number" name="default_class_capacity" class="form-control" value="{{ $settings['default_class_capacity'] ?? 30 }}" min="10" max="60">
                                                    </div>
    
                                                    <div class="settings-group">
                                                        <label class="settings-label">Enable Automatic Promotion</label>
                                                        <div class="toggle-switch">
                                                            <input type="checkbox" name="auto_promotion" id="auto_promotion" {{ ($settings['auto_promotion'] ?? false) ? 'checked' : '' }}>
                                                            <label for="auto_promotion">Enable at end of session</label>
                                                        </div>
                                                    </div>
                                                </div>
    
                                                <div class="text-right">
                                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                                </div>
                                            </form>
                                        </div>
    
                                        <div class="tab-pane" id="attendance">
                                            <form action="{{ route('schools.update-attendance-settings') }}" method="POST">
                                                @csrf
                                                @method('PUT')
    
                                                <div class="settings-card">
                                                    <h4>Attendance Configuration</h4>
    
                                                    <div class="settings-group">
                                                        <label class="settings-label">Attendance Method</label>
                                                        <select name="attendance_method" class="form-control" required>
                                                            <option value="daily" {{ ($settings['attendance_method'] ?? 'daily') == 'daily' ? 'selected' : '' }}>
                                                                Daily Attendance</option>
                                                            <option value="session" {{ ($settings['attendance_method'] ?? 'daily') == 'session' ? 'selected' : '' }}>
                                                                Per Session</option>
                                                        </select>
                                                    </div>
    
                                                    <div class="settings-group">
                                                        <label class="settings-label">Late Arrival Threshold (minutes)</label>
                                                        <input type="number" name="late_threshold" class="form-control" value="{{ $settings['late_threshold'] ?? 15 }}" min="1" max="60">
                                                    </div>
    
                                                    <div class="settings-group">
                                                        <label class="settings-label">Send Absence Notifications</label>
                                                        <div class="toggle-switch">
                                                            <input type="checkbox" name="send_absence_notifications" id="send_absence_notifications" {{ ($settings['send_absence_notifications'] ?? true) ? 'checked' : '' }}>
                                                            <label for="send_absence_notifications">Enable notifications</label>
                                                        </div>
                                                    </div>
    
                                                    <div class="settings-group">
                                                        <label class="settings-label">Notification Method</label>
                                                        <select name="absence_notification_method" class="form-control">
                                                            <option value="email" {{ ($settings['absence_notification_method'] ?? 'email') == 'email' ? 'selected' : '' }}>
                                                                Email</option>
                                                            <option value="sms" {{ ($settings['absence_notification_method'] ?? 'email') == 'sms' ? 'selected' : '' }}>
                                                                SMS</option>
                                                            <option value="both" {{ ($settings['absence_notification_method'] ?? 'email') == 'both' ? 'selected' : '' }}>
                                                                Both</option>
                                                        </select>
                                                    </div>
                                                </div>
    
                                                <div class="text-right">
                                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

    <script>
        $(document).ready(function () {
            // Initialize left tabs
            $('.settings-menu .nav-tabs a').click(function (e) {
                e.preventDefault();
                $(this).tab('show');
            });

            // Initialize toggle switches
            $('.toggle-switch input[type="checkbox"]').bootstrapToggle({
                on: 'Enabled',
                off: 'Disabled'
            });
        });
    </script>
    @endpush
</x-tenant-app-layout>