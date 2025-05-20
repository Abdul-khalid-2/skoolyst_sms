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
               

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="breadcome-list">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="breadcome-heading" style="margin-top: 10px">
                                    <h3>All Sections</h3>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="action-buttons">
                                    <a href="{{ route('admin.academic.sections.create') }}" class="btn btn-primary btn-sm" style="color: white">
                                        <i class="fa fa-plus"></i> Add Section
                                    </a>
                                </div>
                                <div class="dropdown-container">
                                    <button class="dropdown-toggle-custom">
                                        <i class="fa fa-ellipsis-v"></i>
                                    </button>
                                    <div class="dropdown-menu-custom">
                                        <a href="{{ route('admin.academic.sections.create') }}" class="btn btn-primary btn-sm" style="color: white">
                                            <i class="fa fa-plus"></i> Add Section
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline13-list">
                        <div class="sparkline13-hd">
                            <div class="main-sparkline13-hd">
                                <h1>All Classes Sections</h1>
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
                                    {{-- data-show-columns="true"  --}}
                                    {{-- data-show-pagination-switch="true"  --}}
                                    {{-- data-show-refresh="true" --}}
                                    {{-- data-key-events="true"  --}}
                                    {{-- data-show-toggle="true"  --}}
                                    data-resizable="true"
                                    {{-- data-cookie="true" --}}
                                    data-cookie-id-table="timetable"
                                    {{-- data-show-export="true"  --}}
                                    {{-- data-click-to-select="true" --}}
                                     {{-- data-export-types="['csv', 'txt', 'excel']" --}}
                                    data-toolbar="#toolbar">
                                    <thead>
                                        <tr>
                                            {{-- <th data-field="state" data-checkbox="true"></th> --}}
                                            <th data-field="id" data-sortable="true">S.no#</th>
                                            <th data-field="class" data-sortable="true">Class</th>
                                            <th data-field="name" data-sortable="true">Section Name</th>
                                            <th data-field="capacity" data-sortable="true">Capacity</th>
                                            <th data-field="students" data-sortable="true">Students</th>
                                            <th data-field="action">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($sections as $section)
                                            <tr @if($section->trashed()) style="opacity: 0.6; background-color: #f8f9fa;" @endif>
                                                <td>
                                                    {{ $section->id }}
                                                    @if($section->trashed())
                                                        <span class="badge badge-danger">Deleted</span>
                                                    @endif
                                                </td>
                                                <td>{{ $section->class->name ?? 'N/A' }}</td>
                                                <td>{{ $section->name }}</td>
                                                <td>{{ $section->capacity }}</td>
                                                <td>{{ $section->students->count() }}</td>
                                                <td>
                                                    <div style="display: flex; align-items: center; gap: 4px;">
                                                        <a href="{{ route('admin.academic.sections.show', encrypt($section->id)) }}"
                                                        class="btn btn-xs btn-success" 
                                                        title="View">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                        
                                                        @unless($section->trashed())
                                                            <a href="{{ route('admin.academic.sections.edit', encrypt($section->id)) }}" 
                                                            class="btn btn-xs btn-primary" 
                                                            title="Edit">
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                        
                                                            <form action="{{ route('admin.academic.sections.destroy', encrypt($section->id)) }}" 
                                                                method="POST" 
                                                                class="delete-form">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" 
                                                                        class="btn btn-xs btn-danger" 
                                                                        title="Delete"
                                                                        onclick="return confirm('Are you sure you want to delete this section?')">
                                                                    <i class="fa fa-close"></i>
                                                                </button>
                                                            </form>
                                                        @else
                                                            <form action="{{ route('admin.academic.sections.restore', encrypt($section->id)) }}" 
                                                                method="POST">
                                                                @csrf
                                                                <button type="submit" 
                                                                        class="btn btn-xs btn-warning" 
                                                                        title="Restore"
                                                                        onclick="return confirm('Are you sure you want to restore this section?')">
                                                                    <i class="fa fa-refresh"></i> Restore
                                                                </button>
                                                            </form>
                                                        @endunless
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