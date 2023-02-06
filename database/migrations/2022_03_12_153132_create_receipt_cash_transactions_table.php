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
            $table->foreignId('accounting_system_id')->constrained();
            $table->foreignId('receipt_reference_id')->constrained();
            $table->unsignedBigInteger('for_receipt_reference_id')->nullable();
            $table->decimal('amount_received', 18, 8);
            $table->integer('deposit_id')->nullable();
            $table->timestamps();

            $table->foreign('for_receipt_reference_id')->references('id')->on('receipt_references');
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
