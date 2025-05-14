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
        Schema::create('teacher_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained('users');
            $table->foreignId('school_id')->nullable()->constrained();
            $table->string('employee_id', 50)->unique();
            $table->text('qualification')->nullable();
            $table->string('specialization', 100)->nullable();
            $table->integer('experience_years')->nullable();
            $table->date('joining_date')->nullable();
            $table->decimal('base_salary', 12, 2)->nullable();
            $table->decimal('current_salary', 12, 2)->nullable();
            $table->date('last_increment_date')->nullable();
            $table->string('salary_grade', 20)->nullable();
            $table->json('bank_details')->nullable();
            $table->json('emergency_contact')->nullable();
            $table->json('documents')->nullable();
            $table->string('signature')->nullable();
            $table->text('bio')->nullable();
            $table->json('social_links')->nullable();
            $table->boolean('is_class_teacher')->default(false);
            $table->foreignId('class_teacher_of')->nullable()->constrained('classes');
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teacher_profiles');
    }
};
