<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceiptCashTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receipt_cash_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('receipt_reference_id');
            $table->unsignedBigInteger('for_receipt_reference_id');
            $table->float('amount_received');
            $table->enum('is_deposited',['yes','no']);
            $table->foreign('receipt_reference_id')->references('id')->on('receipt_references');
            $table->foreign('for_receipt_reference_id')->references('id')->on('receipt_references');
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
        Schema::dropIfExists('receipt_cash_transactions');
    }
}
