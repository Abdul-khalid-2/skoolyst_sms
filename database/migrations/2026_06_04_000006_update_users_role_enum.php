<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('users')
            ->where('role', 'librarian')
            ->update(['role' => 'accountant']);

        if (Schema::hasTable('users')) {
            DB::statement("ALTER TABLE `users` MODIFY `role` ENUM('super-admin', 'admin', 'teacher', 'student', 'parent', 'accountant') NOT NULL");
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('users')) {
            DB::statement("ALTER TABLE `users` MODIFY `role` ENUM('admin', 'teacher', 'parent', 'student', 'accountant', 'librarian') NOT NULL");
        }
    }
};
