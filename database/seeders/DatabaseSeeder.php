<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['super-admin', 'admin', 'teacher', 'student', 'parent', 'accountant'] as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        $mainBranch = Branch::create([
            'name' => 'Main Branch - Hyderabad',
            'address' => 'Hyderabad, Telangana, India',
            'phone' => '+91 40 1234 5678',
            'email' => 'main@skoolyst.com',
            'is_active' => true,
        ]);

        Branch::create([
            'name' => 'Branch 2',
            'address' => 'Secunderabad, Telangana, India',
            'phone' => '+91 40 8765 4321',
            'email' => 'branch2@skoolyst.com',
            'is_active' => true,
        ]);

        DB::table('settings')->insert([
            'app_name' => 'Skoolyst',
            'school_name' => 'Skoolyst',
            'school_email' => 'info@skoolyst.com',
            'school_phone' => '+91 40 1234 5678',
            'school_address' => 'Hyderabad, Telangana, India',
            'established_year' => 2020,
            'principal_name' => 'Principal Name',
            'school_type' => 'international',
            'session_year' => now()->month >= 4
                ? now()->year.'-'.(now()->year + 1)
                : (now()->year - 1).'-'.now()->year,
            'about' => 'Skoolyst is a multi-branch school organization based in Hyderabad.',
            'motto' => 'Learn, Grow, Lead',
            'short_description' => 'Excellence in education across Hyderabad.',
            'primary_color' => '#2563eb',
            'secondary_color' => '#1e40af',
            'student_count_display' => '1200+',
            'teacher_count_display' => '85+',
            'facility_count_display' => '30+',
            'social_links' => json_encode([
                'facebook' => 'https://facebook.com/skoolyst',
                'instagram' => 'https://instagram.com/skoolyst',
            ]),
            'currency' => 'INR',
            'timezone' => 'Asia/Kolkata',
            'date_format' => 'd/m/Y',
            'academic_year_start' => 'April',
            'late_fine_per_day' => 50.00,
            'attendance_type' => 'daily',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

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
            DB::table('sidebar_settings')->insert([
                'menu_key' => $key,
                'label' => $label,
                'icon' => $icon,
                'route' => $route,
                'roles_visible' => json_encode($allRoles),
                'sort_order' => $order,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $superAdmin = User::create([
            'branch_id' => null,
            'name' => 'Super Admin',
            'email' => 'superadmin@skoolyst.com',
            'password' => 'password',
            'role' => 'super-admin',
            'status' => 'active',
        ]);
        $superAdmin->assignRole('super-admin');

        $branchAdmin = User::create([
            'branch_id' => $mainBranch->id,
            'name' => 'Branch Admin',
            'email' => 'admin@skoolyst.com',
            'password' => 'password',
            'role' => 'admin',
            'status' => 'active',
        ]);
        $branchAdmin->assignRole('admin');
    }
}
