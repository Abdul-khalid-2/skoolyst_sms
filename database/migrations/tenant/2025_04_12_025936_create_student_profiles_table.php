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
        Schema::create('student_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users');
            $table->foreignId('school_id')->nullable()->constrained();
            $table->string('admission_no', 50)->unique();
            $table->date('admission_date')->nullable();
            $table->foreignId('class_id')->nullable()->constrained();
            $table->foreignId('section_id')->nullable()->constrained();
            $table->text('previous_school')->nullable();
            $table->json('medical_history')->nullable();
            $table->json('transport_details')->nullable();
            $table->json('hobbies')->nullable();
            $table->json('awards')->nullable();
            $table->json('documents')->nullable();
            $table->string('signature')->nullable();
            $table->boolean('id_card_issued')->default(false);
            $table->string('id_card_number', 20)->nullable();
            $table->string('blood_group', 5)->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_profiles');
    }
};
