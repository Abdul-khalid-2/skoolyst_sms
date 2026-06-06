@if (Auth::user()->hasRole('super-admin') || Auth::user()->hasRole('admin'))
    <nav id="sidebar" class="">
        <div class="sidebar-header">
            <a href="{{ route('dashboard') }}">
                <img class="main-logo" src="{{ $invormentdata->logo_url }}" alt="" style="width: 180px; height:50px; margin-top:10px;margin-bottom:20px;"/>
            </a>
            <strong>
                <a href="{{ route('dashboard') }}">
                    <img src="{{ $invormentdata->logo_url }}" alt="" style="width: 60px; height:50px; margin-left:5px;margin-right:5px;"/>
                </a>
            </strong>
        </div>
        <div class="left-custom-menu-adp-wrap comment-scrollbar" style="height: calc(100vh - 100px); overflow-y: auto;">
            <nav class="sidebar-nav left-sidebar-menu-pro">
                <ul class="metismenu" id="menu1">

                    <!-- School Admin Panel -->
                    <li><h6 style="color: rgb(95, 95, 95);padding-left:20px" class="mini-click-non">School Admin Panel</h6></li>
                    <li>
                        <a title="Dashboard" href="{{ route('dashboard') }}" aria-expanded="false">
                            <span class="icon-wrap sub-icon-mg"><i class="fa fa-tachometer" aria-hidden="true"></i></span>
                            <span class="mini-click-non">Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a title="School Profile" href="{{ route('schools.show') }}" aria-expanded="false">
                            <span class="icon-wrap sub-icon-mg"><i class="fa fa-university" aria-hidden="true"></i></span>
                            <span class="mini-click-non">School Profile</span>
                        </a>
                    </li>
                    <li>
                        <a class="has-arrow" href="javascript:void(0)">
                            <span class="icon-wrap"><i class="fa fa-graduation-cap" aria-hidden="true"></i></span>
                            <span class="mini-click-non">Academic Setup</span>
                        </a>
                        <ul class="submenu-angle" aria-expanded="false">
                            <li><a href="{{ route('admin.academic.classes.index') }}">Classes</a></li>
                            <li><a href="{{ route('admin.academic.sections.index') }}">Sections</a></li>
                            <li><a href="{{ route('admin.academic.subjects.index') }}">Subjects</a></li>
                            <li><a href="{{ route('admin.timetable.index') }}">Time table</a></li>
                        </ul>
                    </li>
                    <li>
                        <a class="has-arrow" href="javascript:void(0)">
                            <span class="icon-wrap sub-icon-mg"><i class="fa fa-users" aria-hidden="true"></i></span>
                            <span class="mini-click-non">Users Manage</span>
                        </a>
                        <ul class="submenu-angle" aria-expanded="false">
                            <li><a href="{{ route('dashboard.teachers') }}">Teachers</a></li>
                            <li><a href="{{ route('dashboard.students') }}">Students</a></li>
                            <li><a href="{{ route('dashboard.parents') }}">Parents</a></li>
                        </ul>
                    </li>
                    <li>
                        <a title="Attendance" href="{{ route('admin.attendance.index') }}" aria-expanded="false">
                            <span class="icon-wrap sub-icon-mg"><i class="fa fa-calendar-check-o" aria-hidden="true"></i></span>
                            <span class="mini-click-non">Attendance</span>
                        </a>
                    </li>
                    <li>
                        <a class="has-arrow" href="javascript:void(0)">
                            <span class="icon-wrap"><i class="fa fa-money" aria-hidden="true"></i></span>
                            <span class="mini-click-non">Fees Management</span>
                        </a>
                        <ul class="submenu-angle" aria-expanded="false">
                            <li><a href="{{ route('fees.index') }}">Dashboard</a></li>
                            <li><a href="{{ route('fees.categories.index') }}">Categories</a></li>
                            <li><a href="{{ route('fees.structures.index') }}">Structures</a></li>
                            <li><a href="{{ route('fees.payments.index') }}">Payments</a></li>
                        </ul>
                    </li>
                    <li>
                        <a class="has-arrow" href="javascript:void(0)">
                            <span class="icon-wrap"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></span>
                            <span class="mini-click-non">Exams</span>
                        </a>
                        <ul class="submenu-angle" aria-expanded="false">
                            <li><a href="{{ route('exams.index') }}">All Exams</a></li>
                            <li><a href="{{ route('exams.create') }}">Create Exam</a></li>
                        </ul>
                    </li>
                    <li>
                        <a class="has-arrow" href="javascript:void(0)">
                            <span class="icon-wrap"><i class="fa fa-book" aria-hidden="true"></i></span>
                            <span class="mini-click-non">Library</span>
                        </a>
                        <ul class="submenu-angle" aria-expanded="false">
                            <li><a href="{{ route('library.index') }}">Dashboard</a></li>
                            <li><a href="{{ route('library.books.index') }}">Books</a></li>
                            <li><a href="{{ route('library.issues.index') }}">Issues</a></li>
                        </ul>
                    </li>
                    <li>
                        <a class="has-arrow" href="javascript:void(0)">
                            <span class="icon-wrap"><i class="fa fa-cubes" aria-hidden="true"></i></span>
                            <span class="mini-click-non">Inventory</span>
                        </a>
                        <ul class="submenu-angle" aria-expanded="false">
                            <li><a href="{{ route('inventory.index') }}">Dashboard</a></li>
                            <li><a href="{{ route('inventory.items.index') }}">Items</a></li>
                            <li><a href="{{ route('inventory.transactions.index') }}">Transactions</a></li>
                        </ul>
                    </li>
                    <li>
                        <a title="Notices" href="{{ route('notices.index') }}" aria-expanded="false">
                            <span class="icon-wrap sub-icon-mg"><i class="fa fa-bullhorn" aria-hidden="true"></i></span>
                            <span class="mini-click-non">Notices</span>
                        </a>
                    </li>
                    <li>
                        <a title="Holidays" href="{{ route('holidays.index') }}" aria-expanded="false">
                            <span class="icon-wrap sub-icon-mg"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                            <span class="mini-click-non">Holidays</span>
                        </a>
                    </li>
                    <li>
                        <a title="Reports" href="{{ route('reports.index') }}" aria-expanded="false">
                            <span class="icon-wrap sub-icon-mg"><i class="fa fa-bar-chart" aria-hidden="true"></i></span>
                            <span class="mini-click-non">Reports</span>
                        </a>
                    </li>
                    @if(auth()->user()->hasRole('super-admin'))
                    <li>
                        <a title="Platform Settings" href="{{ route('admin.platform.index') }}" aria-expanded="false">
                            <span class="icon-wrap sub-icon-mg"><i class="fa fa-cog" aria-hidden="true"></i></span>
                            <span class="mini-click-non">Settings</span>
                        </a>
                    </li>
                    @endif

                    <!-- Common Features -->
                    <li><h6 style="color: rgb(95, 95, 95);padding-left:20px" class="mini-click-non">Common Features</h6></li>
                    <li>
                        <a title="Notifications" href="javascript:void(0)" aria-expanded="false">
                            <span class="icon-wrap sub-icon-mg"><i class="fa fa-bell" aria-hidden="true"></i></span>
                            <span class="mini-click-non">Notifications</span>
                        </a>
                    </li>
                    <li>
                        <a title="My Account" href="javascript:void(0)" aria-expanded="false">
                            <span class="icon-wrap sub-icon-mg"><i class="fa fa-user-circle" aria-hidden="true"></i></span>
                            <span class="mini-click-non">My Account</span>
                        </a>
                    </li>
                    <li>
                        <a title="Logout" href="{{ route('logout') }}" aria-expanded="false">
                            <span class="icon-wrap sub-icon-mg"><i class="fa fa-sign-out" aria-hidden="true"></i></span>
                            <span class="mini-click-non">Logout</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </nav>
@elseif (Auth::user()->hasRole('teacher'))
    <!-- Teacher Panel -->
    <nav id="sidebar" class="">
        <div class="sidebar-header">
            <a href="index.html"><img class="main-logo" src="{{ asset('backend/img/logo/logo.png') }}" alt="" /></a>
            <strong><a href="index.html"><img src="{{ asset('backend/img/logo/logosn.png') }}" alt="" /></a></strong>
        </div>
        <div class="left-custom-menu-adp-wrap comment-scrollbar">
            <nav class="sidebar-nav left-sidebar-menu-pro">
                <ul class="metismenu" id="menu1">
                    <li><h6 style="color: rgb(95, 95, 95);padding-left:20px" class="mini-click-non">Teacher Panel</h6></li>
                    <li>
                        <a title="Dashboard" href="" aria-expanded="false">
                            <span class="icon-wrap sub-icon-mg"><i class="fa fa-tachometer" aria-hidden="true"></i></span>
                            <span class="mini-click-non"> Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a title="My Profile" href="" aria-expanded="false">
                            <span class="icon-wrap sub-icon-mg"><i class="fa fa-id-card" aria-hidden="true"></i></span>
                            <span class="mini-click-non"> My Profile</span>
                        </a>
                    </li>
                    <li>
                        <a title="My Students" href="" aria-expanded="false">
                            <span class="icon-wrap sub-icon-mg"><i class="fa fa-user-graduate fa fa-users" aria-hidden="true"></i></span>
                            <span class="mini-click-non"> My Students</span>
                        </a>
                    </li>
                    <li>
                        <a title="Mark Attendance" href="" aria-expanded="false">
                            <span class="icon-wrap sub-icon-mg"><i class="fa fa-calendar-check-o" aria-hidden="true"></i></span>
                            <span class="mini-click-non"> Mark Attendance</span>
                        </a>
                    </li>
                    <li>
                        <a class="has-arrow" href="javascript:void(0)">
                            <span class="icon-wrap"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></span>
                            <span class="mini-click-non"> Exams</span>
                        </a>
                        <ul class="submenu-angle" aria-expanded="false">
                            <li><a href="">Create Tests</a></li>
                            <li><a href="">Enter Marks</a></li>
                        </ul>
                    </li>
                    <li>
                        <a title="Subjects" href="" aria-expanded="false">
                            <span class="icon-wrap sub-icon-mg"><i class="fa fa-flask" aria-hidden="true"></i></span>
                            <span class="mini-click-non"> Subjects</span>
                        </a>
                    </li>
                    <li>
                        <a title="My Reports" href="" aria-expanded="false">
                            <span class="icon-wrap sub-icon-mg"><i class="fa fa-bar-chart" aria-hidden="true"></i></span>
                            <span class="mini-click-non"> My Reports</span>
                        </a>
                    </li>

                    <!-- Common Features -->
                    <li><h6 style="color: rgb(95, 95, 95);padding-left:20px" class="mini-click-non">Common Features</h6></li>
                    <li>
                        <a title="Notifications" href="" aria-expanded="false">
                            <span class="icon-wrap sub-icon-mg"><i class="fa fa-bell" aria-hidden="true"></i></span>
                            <span class="mini-click-non"> Notifications</span>
                        </a>
                    </li>
                    <li>
                        <a title="My Account" href="" aria-expanded="false">
                            <span class="icon-wrap sub-icon-mg"><i class="fa fa-user-circle" aria-hidden="true"></i></span>
                            <span class="mini-click-non"> My Account</span>
                        </a>
                    </li>
                    <li>
                        <a title="Logout" href="" aria-expanded="false">
                            <span class="icon-wrap sub-icon-mg"><i class="fa fa-sign-out" aria-hidden="true"></i></span>
                            <span class="mini-click-non">Logout</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </nav>
@elseif (Auth::user()->hasRole('parent'))

    <!-- Parent Panel -->
    <nav id="sidebar" class="">
        <div class="sidebar-header">
            <a href="index.html"><img class="main-logo" src="{{ asset('backend/img/logo/logo.png') }}" alt="" /></a>
            <strong><a href="index.html"><img src="{{ asset('backend/img/logo/logosn.png') }}" alt="" /></a></strong>
        </div>
        <div class="left-custom-menu-adp-wrap comment-scrollbar">
            <nav class="sidebar-nav left-sidebar-menu-pro">
                <ul class="metismenu" id="menu1">
                    <li><h6 style="color: rgb(95, 95, 95);padding-left:20px" class="mini-click-non">Parent Panel</h6></li>
                    <li>
                        <a title="Dashboard" href="" aria-expanded="false">
                            <span class="icon-wrap sub-icon-mg"><i class="fa fa-tachometer" aria-hidden="true"></i></span>
                            <span class="mini-click-non"> Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a class="has-arrow" href="javascript:void(0)">
                            <span class="icon-wrap"><i class="fa fa-child" aria-hidden="true"></i></span>
                            <span class="mini-click-non"> My Children</span>
                        </a>
                        <ul class="submenu-angle" aria-expanded="false">
                            <li><a href="">Profile</a></li>
                            <li><a href="">Attendance</a></li>
                            <li><a href="">Results</a></li>
                        </ul>
                    </li>
                    <li>
                        <a title="Fee Payments" href="" aria-expanded="false">
                            <span class="icon-wrap sub-icon-mg"><i class="fa fa-credit-card" aria-hidden="true"></i></span>
                            <span class="mini-click-non"> Fee Payments</span>
                        </a>
                    </li>
                    <li>
                        <a title="Library Books" href="" aria-expanded="false">
                            <span class="icon-wrap sub-icon-mg"><i class="fa fa-book" aria-hidden="true"></i></span>
                            <span class="mini-click-non">Library Books</span>
                        </a>
                    </li>
                    <li>
                        <a title="Notices" href="" aria-expanded="false">
                            <span class="icon-wrap sub-icon-mg"><i class="fa fa-bullhorn" aria-hidden="true"></i></span>
                            <span class="mini-click-non"> Notices</span>
                        </a>
                    </li>

                    <!-- Common Features -->
                    <li><h6 style="color: rgb(95, 95, 95);padding-left:20px" class="mini-click-non">Common Features</h6></li>
                    <li>
                        <a title="Notifications" href="" aria-expanded="false">
                            <span class="icon-wrap sub-icon-mg"><i class="fa fa-bell" aria-hidden="true"></i></span>
                            <span class="mini-click-non"> Notifications</span>
                        </a>
                    </li>
                    <li>
                        <a title="My Account" href="" aria-expanded="false">
                            <span class="icon-wrap sub-icon-mg"><i class="fa fa-user-circle" aria-hidden="true"></i></span>
                            <span class="mini-click-non"> My Account</span>
                        </a>
                    </li>
                    <li>
                        <a title="Logout" href="{{ route('logout') }}" aria-expanded="false">
                            <span class="icon-wrap sub-icon-mg"><i class="fa fa-sign-out" aria-hidden="true"></i></span>
                            <span class="mini-click-non">Logout</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </nav>
@elseif (Auth::user()->hasRole('student'))
    <!-- Student Panel -->
    <nav id="sidebar" class="">
        <div class="sidebar-header">
            <a href="index.html"><img class="main-logo" src="{{ asset('backend/img/logo/logo.png') }}" alt="" /></a>
            <strong><a href="index.html"><img src="{{ asset('backend/img/logo/logosn.png') }}" alt="" /></a></strong>
        </div>
        <div class="left-custom-menu-adp-wrap comment-scrollbar">
            <nav class="sidebar-nav left-sidebar-menu-pro">
                <ul class="metismenu" id="menu1">
                    <li><h6 style="color: rgb(95, 95, 95);padding-left:20px" class="mini-click-non">Student Panel</h6></li>
                    <li>
                        <a title="Dashboard" href="{{ route('dashboard') }}" aria-expanded="false">
                            <span class="icon-wrap sub-icon-mg"><i class="fa fa-tachometer" aria-hidden="true"></i></span>
                            <span class="mini-click-non"> Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a title="My Profile" href="{{ route('student.profile') }}" aria-expanded="false">
                            <span class="icon-wrap sub-icon-mg"><i class="fa fa-id-card" aria-hidden="true"></i></span>
                            <span class="mini-click-non"> My Profile</span>
                        </a>
                    </li>
                    <li>
                        <a title="My Attendance" href="{{ route('student.attendance') }}" aria-expanded="false">
                            <span class="icon-wrap sub-icon-mg"><i class="fa fa-calendar-check-o" aria-hidden="true"></i></span>
                            <span class="mini-click-non"> My Attendance</span>
                        </a>
                    </li>
                    <li>
                        <a title="My Results" href="{{ route('student.results') }}" aria-expanded="false">
                            <span class="icon-wrap sub-icon-mg"><i class="fa fa-trophy" aria-hidden="true"></i></span>
                            <span class="mini-click-non"> My Results</span>
                        </a>
                    </li>
                    <li>
                        <a title="Fee Status" href="" aria-expanded="false">
                            <span class="icon-wrap sub-icon-mg"><i class="fa fa-credit-card" aria-hidden="true"></i></span>
                            <span class="mini-click-non"> Fee Status</span>
                        </a>
                    </li>
                    <li>
                        <a title="Book Issues" href="" aria-expanded="false">
                            <span class="icon-wrap sub-icon-mg"><i class="fa fa-book" aria-hidden="true"></i></span>
                            <span class="mini-click-non"> Book Issues</span>
                        </a>
                    </li>

                    <!-- Common Features -->
                    <li><h6 style="color: rgb(95, 95, 95);padding-left:20px" class="mini-click-non">Common Features</h6></li>
                    <li>
                        <a title="Notifications" href="" aria-expanded="false">
                            <span class="icon-wrap sub-icon-mg"><i class="fa fa-bell" aria-hidden="true"></i></span>
                            <span class="mini-click-non"> Notifications</span>
                        </a>
                    </li>
                    <li>
                        <a title="My Account" href="" aria-expanded="false">
                            <span class="icon-wrap sub-icon-mg"><i class="fa fa-user-circle" aria-hidden="true"></i></span>
                            <span class="mini-click-non"> My Account</span>
                        </a>
                    </li>
                    <li>
                        <a title="Logout" href="{{ route('logout') }}" aria-expanded="false">
                            <span class="icon-wrap sub-icon-mg"><i class="fa fa-sign-out" aria-hidden="true"></i></span>
                            <span class="mini-click-non"> Logout</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </nav>
@endif
