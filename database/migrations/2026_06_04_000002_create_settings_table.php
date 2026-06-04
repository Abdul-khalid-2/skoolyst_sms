<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('app_name')->default('Skoolyst SMS');
            $table->string('school_name')->nullable();
            $table->string('school_email')->nullable();
            $table->string('school_phone')->nullable();
            $table->text('school_address')->nullable();
            $table->string('school_logo')->nullable();
            $table->string('school_favicon')->nullable();
            $table->string('hero_image')->nullable();
            $table->year('established_year')->nullable();
            $table->string('principal_name')->nullable();
            $table->string('affiliation_no')->nullable();
            $table->string('school_type')->nullable();
            $table->string('session_year', 20)->nullable();
            $table->text('about')->nullable();
            $table->string('motto')->nullable();
            $table->text('short_description')->nullable();
            $table->string('primary_color')->default('#2563eb');
            $table->string('secondary_color')->default('#1e40af');
            $table->string('student_count_display')->nullable();
            $table->string('teacher_count_display')->nullable();
            $table->string('facility_count_display')->nullable();
            $table->json('social_links')->nullable();
            $table->string('currency')->default('USD');
            $table->string('timezone')->default('UTC');
            $table->string('date_format')->default('Y-m-d');
            $table->string('academic_year_start')->nullable();
            $table->decimal('late_fine_per_day', 8, 2)->default(0.00);
            $table->enum('attendance_type', ['daily', 'period'])->default('daily');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
