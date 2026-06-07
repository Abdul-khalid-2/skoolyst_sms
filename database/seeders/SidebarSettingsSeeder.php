<?php

namespace Database\Seeders;

use App\Models\SidebarSetting;
use Illuminate\Database\Seeder;

class SidebarSettingsSeeder extends Seeder
{
    /** Convenience: every role in the system. */
    private const ALL = ['super-admin', 'admin', 'teacher', 'student', 'parent', 'accountant'];

    /**
     * The full sidebar feature catalogue.
     * Format: [menu_key, label, icon, route, sort_order, roles_visible]
     */
    public static function catalog(): array
    {
        return [
            // ── Admin / Super-admin panel ───────────────────────────────
            ['dashboard',         'Dashboard',         'fa fa-tachometer',      'dashboard',                    1,  self::ALL],
            ['school_profile',    'School Profile',    'fa fa-university',      'schools.show',                 2,  ['super-admin', 'admin']],
            ['academic_setup',    'Academic Setup',    'fa fa-graduation-cap',  'admin.academic.setup', 3,  ['super-admin', 'admin']],
            ['people_management', 'Users Manage',      'fa fa-users',           'dashboard.students',           4,  ['super-admin', 'admin']],
            ['attendance',        'Attendance',        'fa fa-calendar-check-o','admin.attendance.index',       5,  ['super-admin', 'admin']],
            ['fees',              'Fees Management',   'fa fa-money',           'fees.index',                   6,  ['super-admin', 'admin']],
            ['exams',             'Exams',             'fa fa-pencil-square-o', 'exams.index',                  7,  ['super-admin', 'admin']],
            ['library',           'Library',           'fa fa-book',            'library.index',                8,  ['super-admin', 'admin']],
            ['inventory',         'Inventory',         'fa fa-cubes',           'inventory.index',              9,  ['super-admin', 'admin']],
            ['notices',           'Notices',           'fa fa-bullhorn',        'notices.index',                10, ['super-admin', 'admin']],
            ['holidays',          'Holidays',          'fa fa-calendar',        'holidays.index',               11, ['super-admin', 'admin']],
            ['reports',           'Reports',           'fa fa-bar-chart',       'reports.index',                12, ['super-admin', 'admin']],
            ['settings',          'Platform Settings', 'fa fa-cog',             'admin.platform.index',         13, ['super-admin']],
            ['branches',          'Branches',          'fa fa-sitemap',         'admin.branches.index',         14, ['super-admin']],
            ['branch_settings',   'Branch Settings',   'fa fa-building',        'branch.settings',              15, ['admin']],

            // ── Student panel ───────────────────────────────────────────
            ['student_profile',    'My Profile',    'fa fa-id-card',           'student.profile',    20, ['student']],
            ['student_attendance', 'My Attendance', 'fa fa-calendar-check-o',  'student.attendance', 21, ['student']],
            ['student_results',    'My Results',    'fa fa-trophy',            'student.results',    22, ['student']],
            ['student_fees',       'Fee Status',    'fa fa-credit-card',       'student.fees',       23, ['student']],
            ['student_books',      'Book Issues',   'fa fa-book',              'student.books',      24, ['student']],
            ['student_timetable',  'My Timetable',  'fa fa-calendar',          'student.timetable',  25, ['student']],
            ['student_notices',    'Notices',       'fa fa-bullhorn',          'student.notices',    26, ['student']],

            // ── Teacher panel ───────────────────────────────────────────
            ['teacher_profile',    'My Profile',      'fa fa-id-card',           'teacher.profile', 30, ['teacher']],
            ['teacher_students',   'My Students',     'fa fa-users',             'teacher.students', 31, ['teacher']],
            ['teacher_attendance', 'Mark Attendance', 'fa fa-calendar-check-o',  'teacher.attendance', 32, ['teacher']],
            ['teacher_exams',      'Exams',           'fa fa-pencil-square-o',   'teacher.exams.tests.index', 33, ['teacher']],
            ['teacher_subjects',   'Subjects',        'fa fa-flask',             'teacher.subjects', 34, ['teacher']],
            ['teacher_timetable',  'My Timetable',    'fa fa-calendar',          'teacher.timetable', 35, ['teacher']],
            ['teacher_reports',    'My Reports',      'fa fa-bar-chart',         'teacher.reports', 36, ['teacher']],

            // ── Parent panel ────────────────────────────────────────────
            ['parent_children', 'My Children',  'fa fa-child',       'parent.children', 40, ['parent']],
            ['parent_fees',     'Fee Payments', 'fa fa-credit-card', 'parent.fees',     41, ['parent']],
            ['parent_library',  'Library Books','fa fa-book',        'parent.books',    42, ['parent']],
            ['parent_notices',  'Notices',      'fa fa-bullhorn',    'parent.notices',  43, ['parent']],

            // ── Accountant panel ────────────────────────────────────────
            ['accountant_fees',     'Fees',     'fa fa-money',         'accountant.fees',     50, ['accountant']],
            ['accountant_payments', 'Payments', 'fa fa-credit-card',   'accountant.payments', 51, ['accountant']],
            ['accountant_reports',  'Reports',  'fa fa-bar-chart',     'accountant.reports',  52, ['accountant']],

            // ── Common features (all panels) ────────────────────────────
            ['notifications', 'Notifications', 'fa fa-bell',         'notifications.index', 90, self::ALL],
            ['my_account',    'My Account',    'fa fa-user-circle',  '',                    91, self::ALL],
        ];
    }

    public function run(): void
    {
        foreach (self::catalog() as [$key, $label, $icon, $route, $order, $roles]) {
            SidebarSetting::updateOrCreate(
                ['menu_key' => $key],
                [
                    'label'         => $label,
                    'icon'          => $icon,
                    'route'         => $route ?: null,
                    'roles_visible' => $roles,
                    'sort_order'    => $order,
                    'is_active'     => true,
                ]
            );
        }

        SidebarSetting::clearCache();
    }
}
