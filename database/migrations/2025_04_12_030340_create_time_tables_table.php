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
        Schema::create('time_tables', function (Blueprint $table) {
            $table->id();

            // Foreign keys with proper constraints
            $table->foreignId('school_id')->constrained()->onDelete('cascade');
            $table->foreignId('class_id')->constrained()->onDelete('cascade');
            $table->foreignId('section_id')->constrained()->onDelete('cascade');
            $table->foreignId('subject_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('teacher_id')->nullable()->constrained('users')->onDelete('set null');

            // Schedule information
            $table->enum('day_of_week', ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']);
            $table->string('period_name', 50);
            $table->time('start_time');
            $table->time('end_time');
            $table->string('room_number', 20)->nullable();

            // Break information
            $table->boolean('is_break')->default(false);
            $table->string('break_name', 50)->nullable();

            // Recurring schedule options
            $table->boolean('is_recurring')->default(true);
            $table->date('effective_from')->nullable();
            $table->date('effective_to')->nullable();

            // Timestamps
            $table->softDeletes();
            $table->timestamps();

            // Unique constraint to prevent duplicate schedules
            $table->unique(
                ['class_id', 'section_id', 'day_of_week', 'start_time'],
                'tt_class_schedule'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('time_tables');
    }
};
