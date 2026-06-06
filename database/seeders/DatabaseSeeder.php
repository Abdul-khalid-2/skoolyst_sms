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

        $this->call(PermissionsSeeder::class);

        $mainBranch = Branch::firstOrCreate(
            ['email' => 'main@skoolyst.com'],
            [
                'name'      => 'Main Branch - Hyderabad',
                'address'   => 'Hyderabad, Telangana, India',
                'phone'     => '+91 40 1234 5678',
                'is_active' => true,
            ]
        );

        Branch::firstOrCreate(
            ['email' => 'branch2@skoolyst.com'],
            [
                'name'      => 'Branch 2',
                'address'   => 'Secunderabad, Telangana, India',
                'phone'     => '+91 40 8765 4321',
                'is_active' => true,
            ]
        );

        if (DB::table('settings')->doesntExist()) {
            DB::table('settings')->insert([
                'app_name'               => 'Skoolyst',
                'school_name'            => 'Skoolyst',
                'school_email'           => 'info@skoolyst.com',
                'school_phone'           => '+91 40 1234 5678',
                'school_address'         => 'Hyderabad, Telangana, India',
                'established_year'       => 2020,
                'principal_name'         => 'Principal Name',
                'school_type'            => 'international',
                'session_year'           => now()->month >= 4
                    ? now()->year . '-' . (now()->year + 1)
                    : (now()->year - 1) . '-' . now()->year,
                'about'                  => 'Skoolyst is a multi-branch school organization based in Hyderabad.',
                'motto'                  => 'Learn, Grow, Lead',
                'short_description'      => 'Excellence in education across Hyderabad.',
                'primary_color'          => '#2563eb',
                'secondary_color'        => '#1e40af',
                'student_count_display'  => '1200+',
                'teacher_count_display'  => '85+',
                'facility_count_display' => '30+',
                'social_links'           => json_encode([
                    'facebook'  => 'https://facebook.com/skoolyst',
                    'instagram' => 'https://instagram.com/skoolyst',
                ]),
                'currency'               => 'INR',
                'timezone'               => 'Asia/Kolkata',
                'date_format'            => 'd/m/Y',
                'academic_year_start'    => 'April',
                'late_fine_per_day'      => 50.00,
                'attendance_type'        => 'daily',
                'created_at'             => now(),
                'updated_at'             => now(),
            ]);
        }

        $allRoles     = ['super-admin', 'admin', 'teacher', 'student', 'parent', 'accountant'];
        $sidebarItems = [
            ['dashboard',         'Dashboard',      'fa fa-tachometer',      'dashboard',                    1],
            ['school_profile',    'School Profile',  'fa fa-building',        'schools.show',                 2],
            ['academic_setup',    'Academic Setup',  'fa fa-graduation-cap',  'admin.academic.classes.index', 3],
            ['people_management', 'People',          'fa fa-users',           'dashboard.students',           4],
            ['attendance',        'Attendance',      'fa fa-check-square-o',  'admin.attendance.index',       5],
            ['fees',              'Fees',             'fa fa-money',           'fees.index',                  6],
            ['exams',             'Exams',            'fa fa-pencil-square-o', 'exams.index',                 7],
            ['library',           'Library',          'fa fa-book',            'library.index',               8],
            ['inventory',         'Inventory',        'fa fa-archive',         'inventory.index',             9],
            ['notices',           'Notices',          'fa fa-bullhorn',        'notices.index',               10],
            ['holidays',          'Holidays',         'fa fa-calendar',        'holidays.index',              11],
            ['reports',           'Reports',          'fa fa-bar-chart',       'reports.index',               12],
            ['settings',          'Settings',         'fa fa-cog',             'admin.settings.index',        13],
            ['notifications',     'Notifications',    'fa fa-bell',            'notifications.index',         14],
        ];

        foreach ($sidebarItems as [$key, $label, $icon, $route, $order]) {
            DB::table('sidebar_settings')->updateOrInsert(
                ['menu_key' => $key],
                [
                    'label'        => $label,
                    'icon'         => $icon,
                    'route'        => $route,
                    'roles_visible' => json_encode($allRoles),
                    'sort_order'   => $order,
                    'is_active'    => true,
                    'created_at'   => now(),
                    'updated_at'   => now(),
                ]
            );
        }

        $superAdmin = User::firstOrCreate(
            ['email' => 'superadmin@skoolyst.com'],
            [
                'branch_id' => null,
                'name'      => 'Super Admin',
                'password'  => 'password',
                'role'      => 'super-admin',
                'status'    => 'active',
            ]
        );
        if (! $superAdmin->hasRole('super-admin')) {
            $superAdmin->assignRole('super-admin');
        }

        $branchAdmin = User::firstOrCreate(
            ['email' => 'admin@skoolyst.com'],
            [
                'branch_id' => $mainBranch->id,
                'name'      => 'Branch Admin',
                'password'  => 'password',
                'role'      => 'admin',
                'status'    => 'active',
            ]
        );
        if (! $branchAdmin->hasRole('admin')) {
            $branchAdmin->assignRole('admin');
        }

        $this->call([
            TestDataSeeder::class,
            ParentsSeeder::class,
            FeesSeeder::class,
            ExamsSeeder::class,
            LibrarySeeder::class,
            InventorySeeder::class,
            NoticesSeeder::class,
            HolidaysSeeder::class,
        ]);
    }
}
