<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddTeacherSalaryManagement extends Migration
{
    public function up()
    {

        Schema::create('salary_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('teacher_id');
            $table->unsignedBigInteger('school_id');
            $table->date('payment_date');
            $table->decimal('amount', 12, 2);
            $table->decimal('bonus', 12, 2)->default(0);
            $table->decimal('deductions', 12, 2)->default(0);
            $table->decimal('tax_amount', 12, 2)->default(0);
            $table->string('payment_method', 20)->nullable();
            $table->string('transaction_reference', 100)->nullable();
            $table->string('status', 20)->default('pending');
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('recorded_by')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('teacher_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('school_id')->references('id')->on('schools')->cascadeOnDelete();
            $table->foreign('recorded_by')->references('id')->on('users')->nullOnDelete();
        });

        // DB::statement("UPDATE teacher_profiles SET base_salary = CASE salary_grade
        //     WHEN 'SG-3' THEN 30000 WHEN 'SG-4' THEN 40000
        //     WHEN 'SG-5' THEN 50000 WHEN 'SG-6' THEN 60000
        //     ELSE 30000 END, current_salary = base_salary WHERE salary_grade IS NOT NULL");
    }

    public function down()
    {
        Schema::dropIfExists('salary_payments');
    }
}
