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
            $table->unsignedBigInteger('payment_reference_id');
            $table->unsignedBigInteger('payment_reference_number');
            $table->unsignedBigInteger('accounting_period_id')->nullable();
            $table->unsignedBigInteger('chart_of_account_id')->nullable();
            $table->unsignedBigInteger('cheque_number');
            $table->float('amount_received');
            $table->timestamps();
            $table->foreign('payment_reference_id')->references('id')->on('payment_references');
            $table->foreign('accounting_period_id')->nullable()->references('id')->on('accounting_periods');
            $table->foreign('chart_of_account_id')->nullable()->references('id')->on('chart_of_accounts');

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
