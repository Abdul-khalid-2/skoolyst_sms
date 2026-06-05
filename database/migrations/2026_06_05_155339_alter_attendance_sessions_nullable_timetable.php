<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('attendance_sessions', function (Blueprint $table) {
            // MySQL won't drop the unique index while the FK exists — drop FK first
            $table->dropForeign(['time_table_id']);
            $table->dropUnique(['time_table_id', 'date']);

            // Re-add as nullable FK
            $table->unsignedBigInteger('time_table_id')->nullable()->change();
            $table->foreign('time_table_id')->references('id')->on('time_tables')->nullOnDelete();

            // Add class/section so full-day sessions can be uniquely matched
            $table->foreignId('class_id')->nullable()->after('time_table_id')->constrained('classes');
            $table->foreignId('section_id')->nullable()->after('class_id')->constrained('sections');
        });
    }

    public function down(): void
    {
        Schema::table('attendance_sessions', function (Blueprint $table) {
            $table->dropConstrainedForeignId('section_id');
            $table->dropConstrainedForeignId('class_id');
            $table->dropForeign(['time_table_id']);
            $table->unsignedBigInteger('time_table_id')->nullable(false)->change();
            $table->foreign('time_table_id')->references('id')->on('time_tables');
            $table->unique(['time_table_id', 'date']);
        });
    }
};
