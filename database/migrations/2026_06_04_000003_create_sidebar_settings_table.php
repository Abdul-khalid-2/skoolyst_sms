<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sidebar_settings', function (Blueprint $table) {
            $table->id();
            $table->string('menu_key')->unique();
            $table->string('label');
            $table->string('icon')->nullable();
            $table->string('route')->nullable();
            $table->json('roles_visible')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sidebar_settings');
    }
};
