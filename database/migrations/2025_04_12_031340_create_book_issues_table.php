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
        Schema::create('book_issues', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->nullable()->constrained();
            $table->foreignId('book_id')->constrained();
            $table->foreignId('user_id')->constrained('users');
            $table->date('issue_date');
            $table->date('return_date')->nullable();
            $table->date('due_date');
            $table->enum('status', ['issued', 'returned', 'lost', 'damaged'])->default('issued');
            $table->decimal('fine_amount', 10, 2)->default(0);
            $table->text('notes')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_issues');
    }
};
