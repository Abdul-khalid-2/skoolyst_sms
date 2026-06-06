<x-tenant-app-layout>
    <x-slot name="header"></x-slot>

    <div class="data-table-area mg-b-15">
        <div class="container-fluid">
            <div class="row">

                <x-page-header title="Roles Overview">
                    <a href="{{ route('admin.platform.permissions') }}" style="color:#333;"><i class="fa fa-key"></i> Edit Permissions</a>
                    <a href="{{ route('admin.platform.index') }}" style="color:#333;"><i class="fa fa-th-large"></i> Platform Settings</a>
                </x-page-header>

                <div class="col-lg-12">
                    <div class="sparkline13-list">
                        <div class="sparkline13-graph">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Role</th>
                                            <th>Permissions</th>
                                            <th>Users</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($roles as $i => $role)
                                            <tr>
                                                <td>{{ $i + 1 }}</td>
                                                <td><strong>{{ ucfirst(str_replace('-', ' ', $role->name)) }}</strong></td>
                                                <td>
                                                    @if($role->name === 'super-admin')
                                                        <span class="label label-warning">Full Access</span>
                                                    @else
                                                        <span class="badge badge-info">{{ $role->permissions_count }}</span>
                                                    @endif
                                                </td>
                                                <td>{{ $role->users_count }}</td>
                                                <td>
                                                    <a href="{{ route('admin.platform.permissions', ['role' => $role->name]) }}"
                                                       class="btn btn-xs btn-primary" title="Edit Permissions">
                                                        <i class="fa fa-key"></i> Permissions
                                                    </a>
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
</x-tenant-app-layout>
