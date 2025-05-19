<x-tenant-app-layout>
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
    <link rel="stylesheet" href="{{ asset('backend/style.css') }}">
    <!-- responsive CSS
        ============================================ -->
    <link rel="stylesheet" href="{{ asset('backend/css/responsive.css') }}">
    <!-- modernizr JS
        ============================================ -->
    <script src="{{ asset('backend/js/vendor/modernizr-2.8.3.min.js') }}"></script>
@endpush
    <x-slot name="header"></x-slot>
    
    <div class="data-table-area mg-b-15">
        <div class="container-fluid">
            <div class="row">
                {{-- <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="breadcome-list">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="breadcome-heading" style="margin-top: 10px">
                                    <h3>All Subjects</h3>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <ul class="breadcome-menu">
                                    <li>
                                        <a href="{{ route('admin.academic.subjects.create') }}" class="btn btn-primary btn-sm" style="color: white">
                                            <i class="fa fa-plus"></i> Add Subject
                                        </a>
                                        <a href="{{ route('admin.academic.subjects.assign') }}" class="btn btn-info btn-sm" style="color: white; margin-left: 10px">
                                            <i class="fa fa-user-tie"></i> Assign Teachers
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>               --}}

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="breadcome-list">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="breadcome-heading" style="margin-top: 10px">
                                <h3>All Subjects</h3>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="action-buttons">
                                <a href="{{ route('admin.academic.subjects.create') }}" class="btn btn-primary btn-sm" style="color: white">
                                    <i class="fa fa-plus"></i> Add Subject
                                </a>
                                <a href="{{ route('admin.academic.subjects.assign') }}" class="btn btn-info btn-sm" style="color: white;">
                                    <i class="fa fa-user-tie"></i> Assign Teachers
                                </a>
                            </div>
                        </div>
                        <div class="dropdown-container">
                            <button class="dropdown-toggle-custom">
                                <i class="fa fa-ellipsis-v"></i>
                            </button>
                            <div class="dropdown-menu-custom">
                                <a href="{{ route('admin.academic.subjects.create') }}" class="btn btn-primary btn-sm" style="color: white">
                                    <i class="fa fa-plus"></i> Add Subject
                                </a>
                                <a href="{{ route('admin.academic.subjects.assign') }}" class="btn btn-info btn-sm" style="color: white;">
                                    <i class="fa fa-user-tie"></i> Assign Teachers
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline13-list">
                        <div class="sparkline13-hd">
                            <div class="main-sparkline13-hd">
                                <h1>All Subject In School</h1>
                            </div>
                        </div>
                        <div class="sparkline13-graph">
                            <div class="datatable-dashv1-list custom-datatable-overright">
                                <div id="toolbar">
                                    <select class="form-control dt-tb">
                                        <option value="">Excel</option>
                                        <option value="">PDF</option>
                                        <option value="">CSV</option>
                                    </select>
                                </div>
                                <table id="timetable-table" 
                                    class="table hover-table timetable-datatable"
                                    data-toggle="table" 
                                    data-pagination="true" 
                                    data-search="true"
                                    data-resizable="true"
                                    data-cookie-id-table="saveId"
                                    data-toolbar="#toolbar">
                                    <thead>
                                        <tr>
                                            <th data-field="id" data-sortable="true">S.no#</th>
                                            <th data-field="name" data-sortable="true">Subject Name</th>
                                            <th data-field="code" data-sortable="true">Code</th>
                                            {{-- <th data-field="classes">Assigned Teacher & Classes</th> --}}
                                            {{-- <th data-field="teachers">Assigned Teachers</th> --}}
                                            <th data-field="action">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($subjects as $key => $subject)
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td>{{ $subject->name }}</td>
                                            <td>{{ $subject->code }}</td>
                                            {{-- <td>
                                                @if($subject->subjectTeacherClass && $subject->subjectTeacherClass->count())
                                                    @foreach($subject->subjectTeacherClass as $classAssignment)
                                                        <span class="badge badge-info">
                                                            {{ $classAssignment->class->name??"" }} : 
                                                            {{ $classAssignment->teacher->name??"" }}
                                                        </span>
                                                    @endforeach
                                                @else
                                                    Not assigned
                                                @endif
                                            </td> --}}
                                           
                                            <td>
                                                <div style="display: flex; align-items: center; gap: 4px;">
                                                    <a href="{{ route('admin.academic.subjects.edit', $subject->id) }}" 
                                                       class="btn btn-xs btn-success" 
                                                       style="margin-right: 2px;color: white"
                                                       title="Edit">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.academic.subjects.edit', $subject->id) }}" 
                                                       class="btn btn-xs btn-primary" 
                                                       style="margin-right: 2px;color: white"
                                                       title="Edit">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    
                                                    <form action="{{ route('admin.academic.subjects.destroy', $subject->id) }}" 
                                                          method="POST" 
                                                          class="d-inline delete-subject-form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                                class="btn btn-xs btn-danger" 
                                                                style="margin-left: 2px"
                                                                title="Delete"
                                                                data-subject-id="{{ $subject->id }}">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
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
</x-tenant-app-layout>