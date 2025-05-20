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
                <div class="col-lg-12">
                    <div class="sparkline13-list shadow-reset">
                        <div class="sparkline13-hd">
                            <div class="main-sparkline13-hd">
                                <h1>Academic Setup</h1>
                                <div class="sparkline13-outline-icon">
                                    <span class="sparkline13-collapse-link"><i class="fa fa-chevron-up"></i></span>
                                    <span><i class="fa fa-wrench"></i></span>
                                    <span class="sparkline13-collapse-close"><i class="fa fa-times"></i></span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Academic Setup Tabs -->
                        <div class="sparkline13-graph">
                            <div class="datatable-dashv1-list custom-datatable-overright">
                                <ul class="nav nav-tabs" id="academicTabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="classes-tab" data-toggle="tab" href="#classes" role="tab" aria-controls="classes" aria-selected="true">Classes</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="sections-tab" data-toggle="tab" href="#sections" role="tab" aria-controls="sections" aria-selected="false">Sections</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="subjects-tab" data-toggle="tab" href="#subjects" role="tab" aria-controls="subjects" aria-selected="false">Subjects</a>
                                    </li>
                                </ul>
                                
                                <div class="tab-content" id="academicTabsContent">
                                    <!-- Classes Tab -->
                                    <div class="tab-pane fade show active" id="classes" role="tabpanel" aria-labelledby="classes-tab">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Class Name</th>
                                                        <th>Numeric Value</th>
                                                        <th>Class Teacher</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>1</td>
                                                        <td>Class 1</td>
                                                        <td>1</td>
                                                        <td>Sarah Johnson</td>
                                                        <td>
                                                            <button class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></button>
                                                            <button class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></button>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>2</td>
                                                        <td>Class 2</td>
                                                        <td>2</td>
                                                        <td>Michael Brown</td>
                                                        <td>
                                                            <button class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></button>
                                                            <button class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></button>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>3</td>
                                                        <td>Class 3</td>
                                                        <td>3</td>
                                                        <td>Emily Davis</td>
                                                        <td>
                                                            <button class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></button>
                                                            <button class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="text-right">
                                            <button class="btn btn-success">Add New Class</button>
                                        </div>
                                    </div>
                                    
                                    <!-- Sections Tab -->
                                    <div class="tab-pane fade" id="sections" role="tabpanel" aria-labelledby="sections-tab">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Section Name</th>
                                                        <th>Class</th>
                                                        <th>Capacity</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>1</td>
                                                        <td>Section A</td>
                                                        <td>Class 1</td>
                                                        <td>30</td>
                                                        <td>
                                                            <button class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></button>
                                                            <button class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></button>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>2</td>
                                                        <td>Section B</td>
                                                        <td>Class 1</td>
                                                        <td>30</td>
                                                        <td>
                                                            <button class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></button>
                                                            <button class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></button>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>3</td>
                                                        <td>Section A</td>
                                                        <td>Class 2</td>
                                                        <td>30</td>
                                                        <td>
                                                            <button class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></button>
                                                            <button class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="text-right">
                                            <button class="btn btn-success">Add New Section</button>
                                        </div>
                                    </div>
                                    
                                    <!-- Subjects Tab -->
                                    <div class="tab-pane fade" id="subjects" role="tabpanel" aria-labelledby="subjects-tab">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Subject Name</th>
                                                        <th>Code</th>
                                                        <th>Assigned Class</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>1</td>
                                                        <td>Mathematics</td>
                                                        <td>MATH</td>
                                                        <td>All Classes</td>
                                                        <td>
                                                            <button class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></button>
                                                            <button class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></button>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>2</td>
                                                        <td>English</td>
                                                        <td>ENG</td>
                                                        <td>All Classes</td>
                                                        <td>
                                                            <button class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></button>
                                                            <button class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></button>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>3</td>
                                                        <td>Science</td>
                                                        <td>SCI</td>
                                                        <td>Class 3-10</td>
                                                        <td>
                                                            <button class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></button>
                                                            <button class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="text-right">
                                            <button class="btn btn-success">Add New Subject</button>
                                            <button class="btn btn-info">Assign Teachers</button>
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
        
        <script>
            $(document).ready(function() {
                // Initialize tabs
                $('#academicTabs a').on('click', function (e) {
                    e.preventDefault();
                    $(this).tab('show');
                });
                
                // Sample data table initialization (can be customized later)
                $('.table').DataTable({
                    "pageLength": 10,
                    "responsive": true
                });
            });
        </script>
    @endpush
</x-tenant-app-layout>