<x-tenant-app-layout>
    @push('css')
        <style>
            .matrix { background:#fff; border:1px solid #e0e0e0; border-radius:6px; overflow-x:auto; }
            .matrix table { width:100%; border-collapse:collapse; }
            .matrix th, .matrix td { padding:11px 14px; border-bottom:1px solid #f0f0f0; font-size:13px; text-align:center; }
            .matrix th { background:#f8fafc; font-weight:700; color:#475569; }
            .matrix td.feature { text-align:left; font-weight:600; color:#2c3e50; white-space:nowrap; }
            .matrix tr:hover td { background:#fafbfc; }
            .matrix input[type=checkbox] { transform:scale(1.15); cursor:pointer; }
        </style>
    @endpush
    <x-slot name="header"></x-slot>

    <div class="data-table-area mg-b-15">
        <div class="container-fluid">
            <div class="row">

                <x-page-header title="Feature Visibility">
                    <a href="{{ route('admin.platform.permissions') }}" style="color:#333;"><i class="fa fa-key"></i> Role Permissions</a>
                    <a href="{{ route('admin.platform.index') }}" style="color:#333;"><i class="fa fa-th-large"></i> Platform Settings</a>
                </x-page-header>

                <div class="col-lg-12" style="margin-bottom:10px;">
                    <p class="text-muted" style="font-size:13px;">
                        Tick a role to show that sidebar feature for it. Untick <strong>Active</strong> to hide a feature from everyone.
                    </p>
                </div>

                <div class="col-lg-12">
                    <form action="{{ route('admin.platform.features.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="matrix">
                            <table>
                                <thead>
                                    <tr>
                                        <th class="feature" style="text-align:left;">Feature</th>
                                        @foreach($roles as $role)
                                            <th>{{ ucfirst(str_replace('-', ' ', $role)) }}</th>
                                        @endforeach
                                        <th>Active</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($menus as $menu)
                                        <tr>
                                            <td class="feature">
                                                <i class="fa {{ $menu->icon ?: 'fa-circle-o' }}"></i>
                                                {{ $menu->label }}
                                            </td>
                                            @foreach($roles as $role)
                                                <td>
                                                    <input type="checkbox" name="visible[{{ $menu->id }}][]" value="{{ $role }}"
                                                        {{ in_array($role, $menu->roles_visible ?? []) ? 'checked' : '' }}>
                                                </td>
                                            @endforeach
                                            <td>
                                                <input type="checkbox" name="active[{{ $menu->id }}]" value="1"
                                                    {{ $menu->is_active ? 'checked' : '' }}>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="{{ count($roles) + 2 }}" class="text-center text-muted" style="padding:30px;">No sidebar features configured.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div style="margin-top:16px;">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save Visibility</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</x-tenant-app-layout>
