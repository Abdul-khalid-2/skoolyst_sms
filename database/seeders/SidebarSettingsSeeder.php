<?php

namespace Database\Seeders;

use App\Models\SidebarSetting;
use Illuminate\Database\Seeder;

class SidebarSettingsSeeder extends Seeder
{
    public function run(): void
    {
        SidebarSetting::query()->delete();

        $sidebarItems = [
            ['dashboard', 'Dashboard', 'fa fa-tachometer', 'dashboard', 1],
            ['school_profile', 'School Profile', 'fa fa-building', 'schools.show', 2],
            ['academic_setup', 'Academic Setup', 'fa fa-graduation-cap', 'admin.academic.classes.index', 3],
            ['people_management', 'People', 'fa fa-users', 'dashboard.students', 4],
            ['attendance', 'Attendance', 'fa fa-check-square-o', 'admin.attendance.index', 5],
            ['fees', 'Fees', 'fa fa-money', 'fees.index', 6],
            ['exams', 'Exams', 'fa fa-pencil-square-o', 'exams.index', 7],
            ['library', 'Library', 'fa fa-book', 'library.index', 8],
            ['inventory', 'Inventory', 'fa fa-archive', 'inventory.index', 9],
            ['notices', 'Notices', 'fa fa-bullhorn', 'notices.index', 10],
            ['holidays', 'Holidays', 'fa fa-calendar', 'holidays.index', 11],
            ['reports', 'Reports', 'fa fa-bar-chart', 'reports.index', 12],
            ['settings', 'Settings', 'fa fa-cog', 'admin.settings.index', 13],
            ['notifications', 'Notifications', 'fa fa-bell', 'notifications.index', 14],
        ];

        $allRoles = ['super-admin', 'admin', 'teacher', 'student', 'parent', 'accountant'];

        foreach ($sidebarItems as [$key, $label, $icon, $route, $order]) {
            SidebarSetting::create([
                'menu_key' => $key,
                'label' => $label,
                'icon' => $icon,
                'route' => $route,
                'roles_visible' => $allRoles,
                'sort_order' => $order,
                'is_active' => true,
            ]);
        }

        SidebarSetting::clearCache();
    }
}
