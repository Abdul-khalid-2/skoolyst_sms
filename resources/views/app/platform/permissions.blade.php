<x-tenant-app-layout>
    @push('css')
        <style>
            .role-tabs { display:flex; flex-wrap:wrap; gap:8px; margin-bottom:20px; }
            .role-tab { padding:8px 16px; border:1px solid #d8dee6; border-radius:20px; font-size:13px; font-weight:600; color:#475569; text-decoration:none; background:#fff; }
            .role-tab:hover { color:#2563eb; text-decoration:none; }
            .role-tab.active { background:#2563eb; color:#fff; border-color:#2563eb; }
            .perm-card { background:#fff; border:1px solid #e0e0e0; border-radius:6px; padding:16px 18px; margin-bottom:16px; }
            .perm-card h4 { margin:0 0 12px; font-size:14px; font-weight:700; color:#2c3e50; display:flex; justify-content:space-between; align-items:center; }
            .perm-row { display:flex; flex-wrap:wrap; gap:18px; }
            .perm-check { font-weight:normal; font-size:13px; cursor:pointer; user-select:none; }
            .perm-check input { margin-right:6px; }
            .locked-banner { background:#eef2ff; border:1px solid #c7d2fe; color:#3730a3; padding:12px 16px; border-radius:6px; font-size:14px; }
            .group-toggle { font-size:11px; font-weight:600; color:#2563eb; cursor:pointer; }
        </style>
    @endpush
    <x-slot name="header"></x-slot>

    <div class="data-table-area mg-b-15">
        <div class="container-fluid">
            <div class="row">

                <x-page-header title="Role Permissions">
                    <a href="{{ route('admin.platform.features') }}" style="color:#333;"><i class="fa fa-bars"></i> Feature Visibility</a>
                    <a href="{{ route('admin.platform.index') }}" style="color:#333;"><i class="fa fa-th-large"></i> Platform Settings</a>
                </x-page-header>

                {{-- Role selector --}}
                <div class="col-lg-12">
                    <div class="role-tabs">
                        @foreach($roles as $role)
                            <a href="{{ route('admin.platform.permissions', ['role' => $role->name]) }}"
                               class="role-tab {{ $selectedRole && $selectedRole->name === $role->name ? 'active' : '' }}">
                                {{ ucfirst(str_replace('-', ' ', $role->name)) }}
                            </a>
                        @endforeach
                    </div>
                </div>

                @php $isLocked = $selectedRole && $selectedRole->name === 'super-admin'; @endphp

                <div class="col-lg-12">
                    @if($isLocked)
                        <div class="locked-banner">
                            <i class="fa fa-lock"></i> The <strong>Super Admin</strong> role always has full access to every module and cannot be restricted.
                        </div>
                    @else
                        <form action="{{ route('admin.platform.permissions.update') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="role" value="{{ $selectedRole->name }}">

                            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:14px;">
                                <h3 style="margin:0; font-size:16px;">
                                    Permissions for <strong style="color:#2563eb;">{{ ucfirst(str_replace('-', ' ', $selectedRole->name)) }}</strong>
                                </h3>
                                <div>
                                    <span class="group-toggle" onclick="toggleAll(true)">Select all</span> &nbsp;·&nbsp;
                                    <span class="group-toggle" onclick="toggleAll(false)">Clear all</span>
                                </div>
                            </div>

                            <div class="row">
                                @foreach($modules as $key => $config)
                                    <div class="col-lg-6">
                                        <div class="perm-card">
                                            <h4>
                                                {{ $config['label'] }}
                                            </h4>
                                            <div class="perm-row">
                                                @foreach($config['actions'] as $action)
                                                    @php $perm = "{$key}.{$action}"; @endphp
                                                    <label class="perm-check">
                                                        <input type="checkbox" name="permissions[]" value="{{ $perm }}"
                                                            {{ in_array($perm, $rolePerms) ? 'checked' : '' }}>
                                                        {{ ucfirst($action) }}
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div style="margin-top:10px;">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save Permissions</button>
                            </div>
                        </form>
                    @endif
                </div>

            </div>
        </div>
    </div>

    @push('js')
        <script>
        function toggleAll(state) {
            document.querySelectorAll('input[name="permissions[]"]').forEach(cb => cb.checked = state);
        }
        </script>
    @endpush
</x-tenant-app-layout>
