<?php

use Database\Seeders\AcademicDataConsolidationSeeder;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        (new AcademicDataConsolidationSeeder)->run();
    }

    public function down(): void
    {
        // Data consolidation is not reversible automatically.
    }
};
