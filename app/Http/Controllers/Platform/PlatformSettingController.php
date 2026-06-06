<?php

namespace App\Http\Controllers\Platform;

use App\Http\Controllers\Controller;
use App\Models\SidebarSetting;
use Database\Seeders\PermissionsSeeder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PlatformSettingController extends Controller
{
    /** Roles that should never be edited away from full access. */
    private const LOCKED_ROLES = ['super-admin'];

    public function index()
    {
        $stats = [
            'roles'       => Role::count(),
            'permissions' => Permission::count(),
            'menus'       => SidebarSetting::count(),
        ];

        return view('app.platform.index', compact('stats'));
    }

    // ── Feature Visibility (sidebar gates per role) ──────────────────────────
    public function features()
    {
        $menus = SidebarSetting::orderBy('sort_order')->get()
            ->groupBy(fn (SidebarSetting $menu) => $this->panelFor($menu->menu_key));

        $roles = Role::orderBy('name')->pluck('name')->all();

        return view('app.platform.features', compact('menus', 'roles'));
    }

    /** Group a sidebar menu_key into a human-readable panel section. */
    private function panelFor(string $menuKey): string
    {
        return match (true) {
            str_starts_with($menuKey, 'student_') => 'Student Panel',
            str_starts_with($menuKey, 'teacher_') => 'Teacher Panel',
            str_starts_with($menuKey, 'parent_')  => 'Parent Panel',
            in_array($menuKey, ['notifications', 'my_account'], true) => 'Common Features',
            default => 'Admin Panel',
        };
    }

    public function featuresUpdate(Request $request)
    {
        $request->validate([
            'visible'        => 'nullable|array',
            'visible.*'      => 'array',
            'active'         => 'nullable|array',
        ]);

        $visible = $request->input('visible', []); // [menu_id => [role, role, ...]]
        $active  = $request->input('active', []);   // [menu_id => "1"]

        foreach (SidebarSetting::all() as $menu) {
            $menu->update([
                'roles_visible' => array_values($visible[$menu->id] ?? []),
                'is_active'     => isset($active[$menu->id]),
            ]);
        }

        SidebarSetting::clearCache();

        return redirect()->route('admin.platform.features')
            ->with('message', 'Feature visibility updated.')->with('alert-type', 'success');
    }

    // ── Role Permissions ─────────────────────────────────────────────────────
    public function permissions(Request $request)
    {
        $roles        = Role::orderBy('name')->get();
        $selectedRole = $request->role
            ? Role::where('name', $request->role)->first()
            : $roles->firstWhere('name', 'admin') ?? $roles->first();

        $modules      = PermissionsSeeder::MODULES;
        $rolePerms    = $selectedRole ? $selectedRole->permissions->pluck('name')->all() : [];

        return view('app.platform.permissions', compact('roles', 'selectedRole', 'modules', 'rolePerms'));
    }

    public function permissionsUpdate(Request $request)
    {
        $data = $request->validate([
            'role'          => 'required|exists:roles,name',
            'permissions'   => 'nullable|array',
            'permissions.*' => 'string|exists:permissions,name',
        ]);

        if (in_array($data['role'], self::LOCKED_ROLES)) {
            return back()->with('message', 'The Super Admin role always has full access and cannot be modified.')
                ->with('alert-type', 'error');
        }

        $role = Role::where('name', $data['role'])->firstOrFail();
        $role->syncPermissions($data['permissions'] ?? []);

        return redirect()->route('admin.platform.permissions', ['role' => $role->name])
            ->with('message', "Permissions updated for the {$role->name} role.")->with('alert-type', 'success');
    }

    // ── Roles overview ───────────────────────────────────────────────────────
    public function roles()
    {
        $roles = Role::withCount(['permissions', 'users'])->orderBy('name')->get();

        return view('app.platform.roles', compact('roles'));
    }
}
