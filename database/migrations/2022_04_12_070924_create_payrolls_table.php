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
            $table->float('total_salary', 10, 2)->default(0);
            $table->float('total_addition', 10, 2)->default(0);
            $table->float('total_deduction', 10, 2)->default(0);
            $table->float('total_overtime', 10, 2)->default(0);
            $table->float('total_loan', 10, 2)->default(0);
            $table->float('total_tax', 10, 2)->default(0);
            $table->float('total_pension_7', 10, 2)->default(0);
            $table->float('total_pension_11', 10, 2)->default(0);
            $table->float('net_pay', 10, 2)->default(0);
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
