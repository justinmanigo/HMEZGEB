<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVatPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vat_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('payment_reference_id');
            $table->unsignedBigInteger('accounting_period_id')->nullable();
            $table->unsignedBigInteger('chart_of_account_id')->nullable();
            $table->string('type');
            $table->decimal('previous_period_vat_receivable', 18, 8)->nullable();
            $table->decimal('current_period_vat_receivable', 18, 8)->nullable();
            $table->decimal('current_period_vat_payment', 18, 8)->nullable();
            $table->decimal('current_receivable', 18, 8)->nullable();
            $table->foreign('payment_reference_id')->references('id')->on('payment_references'); 
            $table->foreign('accounting_period_id')->nullable()->references('id')->on('accounting_periods'); 
            $table->foreign('chart_of_account_id')->nullable()->references('id')->on('chart_of_accounts'); 
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
        Schema::dropIfExists('vat_payments');
    }
}
