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

        $this->call(SidebarSettingsSeeder::class);

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
