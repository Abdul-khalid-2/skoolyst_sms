<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsSeeder extends Seeder
{
    /**
     * Modules and the actions available on each.
     * 'view'   = can see / read the module
     * 'manage' = can create / edit / delete within the module
     */
    public const MODULES = [
        'dashboard'   => ['label' => 'Dashboard',          'actions' => ['view']],
        'students'    => ['label' => 'Students',           'actions' => ['view', 'manage']],
        'teachers'    => ['label' => 'Teachers',           'actions' => ['view', 'manage']],
        'parents'     => ['label' => 'Parents',            'actions' => ['view', 'manage']],
        'academic'    => ['label' => 'Academic Setup',     'actions' => ['view', 'manage']],
        'attendance'  => ['label' => 'Attendance',         'actions' => ['view', 'manage']],
        'fees'        => ['label' => 'Fees Management',     'actions' => ['view', 'manage']],
        'exams'       => ['label' => 'Exams',              'actions' => ['view', 'manage']],
        'library'     => ['label' => 'Library',            'actions' => ['view', 'manage']],
        'inventory'   => ['label' => 'Inventory',          'actions' => ['view', 'manage']],
        'notices'     => ['label' => 'Notices',            'actions' => ['view', 'manage']],
        'holidays'    => ['label' => 'Holidays',           'actions' => ['view', 'manage']],
        'reports'     => ['label' => 'Reports',            'actions' => ['view']],
        'settings'    => ['label' => 'Platform Settings',  'actions' => ['view', 'manage']],
    ];

    public function run(): void
    {
        // 1. Create every permission
        $all = [];
        foreach (self::MODULES as $module => $config) {
            foreach ($config['actions'] as $action) {
                $name = "{$module}.{$action}";
                Permission::firstOrCreate(['name' => $name, 'guard_name' => 'web']);
                $all[] = $name;
            }
        }
        $this->command->info('✓ ' . count($all) . ' permissions ensured.');

        // 2. Default assignments per role
        $defaults = [
            'super-admin' => $all, // everything
            'admin'       => array_values(array_filter($all, fn ($p) => ! str_starts_with($p, 'settings.'))),
            'teacher'     => [
                'dashboard.view',
                'students.view',
                'attendance.view', 'attendance.manage',
                'exams.view', 'exams.manage',
                'library.view',
                'notices.view',
                'holidays.view',
                'reports.view',
            ],
            'accountant'  => [
                'dashboard.view',
                'fees.view', 'fees.manage',
                'students.view',
                'reports.view',
            ],
            'parent'      => ['dashboard.view', 'notices.view', 'holidays.view'],
            'student'     => ['dashboard.view', 'notices.view', 'holidays.view'],
        ];

        foreach ($defaults as $roleName => $perms) {
            $role = Role::where('name', $roleName)->first();
            if (! $role) continue;

            // Only set defaults if the role has no permissions yet (don't clobber manual edits)
            if ($role->permissions()->count() === 0) {
                $role->syncPermissions($perms);
                $this->command->info("  → {$roleName}: " . count($perms) . ' permissions assigned.');
            }
        }
    }
}
