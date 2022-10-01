<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncomeTaxPayrollRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('income_tax_payroll_rules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('accounting_system_id')->constrained();
            $table->decimal('income', 18, 8);
            $table->decimal('rate', 18, 8);
            $table->decimal('deduction', 18, 8);
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
        Schema::dropIfExists('income_tax_payroll_rules');
    }
}
