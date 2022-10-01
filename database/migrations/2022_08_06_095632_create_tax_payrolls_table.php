<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaxPayrollsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tax_payrolls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('accounting_system_id')->constrained();
            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('payroll_id')->nullable();
            $table->decimal('taxable_income', 18, 6)->default(0);
            $table->decimal('tax_rate', 18, 6)->default(0);
            $table->decimal('tax_deduction', 18, 6)->default(0);
            $table->decimal('tax_amount', 18, 6)->default(0);
            $table->string('type')->default('tax');
            $table->enum('status',['pending','paid','cancelled'])->default('pending');
            $table->foreign('payroll_id')->references('id')->on('payrolls');
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
        Schema::dropIfExists('tax_payrolls');
    }
}
