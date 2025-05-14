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
        Schema::create('schools', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->unique();
            $table->string('logo')->nullable();
            $table->string('session_year', 20)->nullable();
            // New fields
            $table->string('motto')->nullable();
            $table->string('hero_image')->nullable();
            $table->string('student_count')->nullable();
            $table->string('teacher_count')->nullable();
            $table->string('facility_count')->nullable();
            $table->string('primary_color')->default('#2563eb');
            $table->string('secondary_color')->default('#1e40af');
            $table->text('short_description')->nullable();


            $table->string('type')->nullable()->comment('public/private/international');
            $table->string('affiliation')->nullable()->comment('School affiliation number');
            $table->string('principal')->nullable()->comment('Principal name');
            $table->text('about')->nullable()->comment('About school description');
            $table->year('established_year')->nullable()->comment('Year school was established');
            $table->json('social_links')->nullable()->comment('Social media links');
            // Timestamps
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schools');
    }
};
