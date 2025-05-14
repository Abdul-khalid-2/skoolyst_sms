<nav id="sidebar" class="">
    <div class="sidebar-header">
        <a href="index.html"><img class="main-logo" src="{{ asset('backend/img/logo/logo.png') }}" alt="" /></a>
        <strong><a href="index.html"><img src="{{ asset('backend/img/logo/logosn.png') }}" alt="" /></a></strong>
    </div>
    <div class="left-custom-menu-adp-wrap comment-scrollbar">
        <nav class="sidebar-nav left-sidebar-menu-pro">
            <ul class="metismenu" id="menu1">
                
                <li><h6 style="color: rgb(95, 95, 95);padding-left:20px" class="mini-click-non">Supper Admin Modules</h6></li>
                <li>
                    <a title="Landing Page" href="{{ route('dashboard') }}" aria-expanded="false">
                        <span class="educate-icon educate-event icon-wrap sub-icon-mg" aria-hidden="true"></span>
                        <span class="mini-click-non">Dashboard</span>
                    </a>
                </li>
                <li class="active">
                    <a class="has-arrow" href="javascript:void(0)">
                        <span class="educate-icon educate-home icon-wrap"></span>
                        <span class="mini-click-non">Tenant Schools</span>
                    </a>
                    <ul class="submenu-angle" aria-expanded="true">
                        <li><a title="Create New School" href="{{ route('tenant.create') }}"><span class="mini-sub-pro">Create New School</span></a></li>
                        <li><a title="All Schools List" href="{{ route('tenants.index') }}"><span class="mini-sub-pro">All Schools List</span></a></li>
                        <li><a title="School Activation" href="#"><span class="mini-sub-pro">School Activation</span></a></li>
                    </ul>
                </li>
                <li>
                    <a title="System Configuration" href="#" aria-expanded="false">
                        <span class="educate-icon educate-event icon-wrap sub-icon-mg" aria-hidden="true"></span>
                        <span class="mini-click-non">Tenant User</span>
                    </a>
                </li>
                <li>
                    <a title="System Configuration" href="#" aria-expanded="false">
                        <span class="educate-icon educate-event icon-wrap sub-icon-mg" aria-hidden="true"></span>
                        <span class="mini-click-non">System Configuration</span>
                    </a>
                </li>
                <li>
                    <a title="Master Reports" href="#" aria-expanded="false">
                        <span class="educate-icon educate-event icon-wrap sub-icon-mg" aria-hidden="true"></span>
                        <span class="mini-click-non">Master Reports</span>
                    </a>
                </li>
                
            </ul>
        </nav>
    </div>
</nav>