<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('schools');
    }

    public function down(): void
    {
        // schools table is recreated by 2025_04_12_025239_create_schools_table.php on fresh migrate
    }
};
