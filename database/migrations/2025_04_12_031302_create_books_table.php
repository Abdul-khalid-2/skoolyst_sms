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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->nullable()->constrained();
            $table->string('title', 255);
            $table->string('author', 100)->nullable();
            $table->string('isbn', 20)->nullable();
            $table->string('publisher', 100)->nullable();
            $table->string('edition', 20)->nullable();
            $table->string('category', 50)->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->integer('quantity');
            $table->integer('available');
            $table->string('shelf_number', 20)->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
