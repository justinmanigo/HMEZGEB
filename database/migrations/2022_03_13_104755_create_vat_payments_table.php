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
            $table->unsignedBigInteger('vendor_id');
            $table->unsignedBigInteger('payment_reference_id');
            $table->unsignedBigInteger('accounting_period_id');
            $table->date('date');
            $table->float('previous_vat_receivable');
            $table->float('current_vat_receivable');
            $table->float('current_vat_payment');
            $table->foreign('vendor_id')->references('id')->on('vendors'); 
            $table->foreign('payment_reference_id')->references('id')->on('payment_references'); 
            $table->foreign('accounting_period_id')->references('id')->on('accounting_periods'); 
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
