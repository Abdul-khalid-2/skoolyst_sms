<x-tenant-app-layout>
    @push('css')
        <style>
            .pf-card { display:block; background:#fff; border:1px solid #e0e0e0; border-radius:8px; padding:24px 22px; margin-bottom:24px; text-decoration:none; color:inherit; transition:all .15s ease; }
            .pf-card:hover { box-shadow:0 6px 18px rgba(0,0,0,.08); transform:translateY(-2px); color:inherit; text-decoration:none; }
            .pf-icon { width:54px; height:54px; border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:24px; color:#fff; margin-bottom:14px; }
            .pf-card h3 { margin:0 0 6px; font-size:17px; font-weight:700; color:#2c3e50; }
            .pf-card p  { margin:0; font-size:13px; color:#888; line-height:1.5; }
            .pf-stat { background:#fff; border:1px solid #e0e0e0; border-radius:6px; padding:16px 20px; margin-bottom:20px; text-align:center; }
            .pf-stat h2 { margin:4px 0; font-size:26px; font-weight:700; }
            .pf-stat p  { margin:0; font-size:12px; color:#888; }
        </style>
    @endpush
    <x-slot name="header"></x-slot>

    <div class="data-table-area mg-b-15">
        <div class="container-fluid">
            <div class="row">

                <x-page-header title="Platform Settings" />

                <div class="col-lg-12" style="margin-bottom:6px;">
                    <p class="text-muted" style="font-size:14px;">
                        Manage what each role can access and which features appear in their sidebar.
                    </p>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"><div class="pf-stat" style="border-top:3px solid #3498db;"><p>Roles</p><h2>{{ $stats['roles'] }}</h2></div></div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"><div class="pf-stat" style="border-top:3px solid #8e44ad;"><p>Permissions</p><h2>{{ $stats['permissions'] }}</h2></div></div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"><div class="pf-stat" style="border-top:3px solid #27ae60;"><p>Sidebar Features</p><h2>{{ $stats['menus'] }}</h2></div></div>

                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                    <a href="{{ route('admin.platform.permissions') }}" class="pf-card">
                        <div class="pf-icon" style="background:#8e44ad;"><i class="fa fa-key"></i></div>
                        <h3>Role Permissions</h3>
                        <p>Control which modules and actions each role can view and manage.</p>
                    </a>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                    <a href="{{ route('admin.platform.features') }}" class="pf-card">
                        <div class="pf-icon" style="background:#27ae60;"><i class="fa fa-bars"></i></div>
                        <h3>Feature Visibility</h3>
                        <p>Show or hide sidebar features per role, and enable/disable modules.</p>
                    </a>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                    <a href="{{ route('admin.platform.roles') }}" class="pf-card">
                        <div class="pf-icon" style="background:#3498db;"><i class="fa fa-users"></i></div>
                        <h3>Roles Overview</h3>
                        <p>Review all roles with their assigned permissions and user counts.</p>
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-tenant-app-layout>
