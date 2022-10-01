<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayrollsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('payroll_period_id');
            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('accounting_system_id')->constrained();
            $table->enum('status', ['pending', 'partially_paid','paid', 'cancelled'])->default('pending');
            $table->string('paid_by')->nullable();
            $table->decimal('total_salary', 18, 8)->default(0);
            $table->decimal('total_addition', 18, 8)->default(0);
            $table->decimal('total_deduction', 18, 8)->default(0);
            $table->decimal('total_overtime', 18, 8)->default(0);
            $table->decimal('total_loan', 18, 8)->default(0);
            $table->decimal('total_tax', 18, 8)->default(0);
            $table->decimal('total_pension_7', 18, 8)->default(0);
            $table->decimal('total_pension_11', 18, 8)->default(0);
            $table->decimal('net_pay', 18, 8)->default(0);
            $table->foreign('employee_id')->references('id')->on('employees');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payrolls');
    }
}
