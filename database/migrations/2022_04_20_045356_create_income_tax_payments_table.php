<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncomeTaxPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('income_tax_payments', function (Blueprint $table) {
            $table->id();
            $table->integer('payment_reference_id')->nullable(); // foreign
            $table->integer('payroll_period_id')->nullable(); // foreign
            $table->decimal('total_paid', 18, 8);
            $table->string('cheque_number')->nullable();
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
        Schema::dropIfExists('income_tax_payments');
    }
}
