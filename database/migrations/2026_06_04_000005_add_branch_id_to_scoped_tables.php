<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected array $tables = [
        'classes',
        'sections',
        'subjects',
        'teacher_profiles',
        'student_profiles',
        'parent_profiles',
        'time_tables',
        'attendance_sessions',
        'fee_categories',
        'fee_structures',
        'fees',
        'fee_payments',
        'exams',
        'exam_results',
        'exam_schedules',
        'books',
        'book_issues',
        'inventory_items',
        'inventory_transactions',
        'holidays',
        'notices',
        'programs',
        'testimonials',
        'system_settings',
        'salary_payments',
        'student_attendances',
        'audit_logs',
    ];

    public function up(): void
    {
        if (Schema::hasTable('branches') && DB::getDriverName() === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        }

        foreach ($this->tables as $tableName) {
            if (! Schema::hasTable($tableName)) {
                continue;
            }

            if (Schema::hasColumn($tableName, 'school_id')) {
                if (DB::getDriverName() === 'mysql') {
                    $foreign = DB::selectOne(
                        'SELECT constraint_name FROM information_schema.key_column_usage WHERE table_schema = ? AND table_name = ? AND column_name = ? AND referenced_table_name IS NOT NULL',
                        [DB::getDatabaseName(), $tableName, 'school_id']
                    );

                    if ($foreign) {
                        DB::statement("ALTER TABLE `{$tableName}` DROP FOREIGN KEY `{$foreign->constraint_name}`");
                    }
                }

                if ($tableName === 'system_settings') {
                    DB::statement("ALTER TABLE `{$tableName}` DROP INDEX `system_settings_school_id_setting_key_unique`");
                }

                Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                    if (Schema::hasColumn($tableName, 'school_id')) {
                        $table->dropColumn('school_id');
                    }
                });
            }

            Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                if (! Schema::hasColumn($tableName, 'branch_id')) {
                    $table->foreignId('branch_id')->constrained()->after('id');
                }
            });
        }

        if (Schema::hasTable('branches') && DB::getDriverName() === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }
    }

    public function down(): void
    {
        foreach ($this->tables as $tableName) {
            if (! Schema::hasTable($tableName)) {
                continue;
            }

            Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                if (Schema::hasColumn($tableName, 'branch_id')) {
                    $table->dropForeign(['branch_id']);
                    $table->dropColumn('branch_id');
                }

                if (! Schema::hasColumn($tableName, 'school_id')) {
                    $table->foreignId('school_id')->nullable()->constrained()->after('id');
                }
            });
        }
    }
};
