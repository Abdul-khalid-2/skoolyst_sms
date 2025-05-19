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
        Schema::create('parent_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->constrained('users');
            $table->foreignId('school_id')->nullable()->constrained();
            $table->string('occupation', 100)->nullable();
            $table->string('employer', 100)->nullable();
            $table->string('income_range', 50)->nullable();
            $table->string('education_level', 100)->nullable();
            $table->enum('relation_type', ['father', 'mother', 'guardian']);
            $table->boolean('is_primary')->default(false);
            $table->string('address_proof')->nullable();
            $table->string('id_proof')->nullable();
            $table->string('emergency_contact')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parent_profiles');
    }
};
