<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class TenantDatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // User permissions
            'view users',
            'create users',
            'edit users',
            'delete users',
            
            // Student permissions
            'view students',
            'create students',
            'edit students',
            'delete students',
            
            // Teacher permissions
            'view teachers',
            'create teachers',
            'edit teachers',
            'delete teachers',
            
            // Class permissions
            'view classes',
            'create classes',
            'edit classes',
            'delete classes',
            
            // Subject permissions
            'view subjects',
            'create subjects',
            'edit subjects',
            'delete subjects',
            
            // Attendance permissions
            'view attendance',
            'create attendance',
            'edit attendance',
            'delete attendance',
            
            // Grades permissions
            'view grades',
            'create grades',
            'edit grades',
            'delete grades',
            
            // Timetable permissions
            'view timetable',
            'create timetable',
            'edit timetable',
            'delete timetable',
            
            // School settings
            'manage school settings',
            
            // Financial permissions
            'view finances',
            'manage finances',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions
        $superAdmin = Role::create(['name' => 'super-admin']);
        $superAdmin->givePermissionTo(Permission::all());

        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo([
            'view users', 'create users', 'edit users',
            'view students', 'create students', 'edit students',
            'view teachers', 'create teachers', 'edit teachers',
            'view classes', 'create classes', 'edit classes',
            'view subjects', 'create subjects', 'edit subjects',
            'view attendance', 'create attendance', 'edit attendance',
            'view grades', 'create grades', 'edit grades',
            'view timetable', 'create timetable', 'edit timetable',
            'manage school settings',
            'view finances', 'manage finances',
        ]);

        $teacher = Role::create(['name' => 'teacher']);
        $teacher->givePermissionTo([
            'view students',
            'view classes',
            'view subjects',
            'view attendance', 'create attendance', 'edit attendance',
            'view grades', 'create grades', 'edit grades',
            'view timetable',
        ]);

        $student = Role::create(['name' => 'student']);
        $student->givePermissionTo([
            'view attendance',
            'view grades',
            'view timetable',
        ]);

        $parent = Role::create(['name' => 'parent']);
        $parent->givePermissionTo([
            'view attendance',
            'view grades',
            'view timetable',
        ]);

        $accountant = Role::create(['name' => 'accountant']);
        $accountant->givePermissionTo([
            'view finances', 'manage finances',
        ]);
    }
}
