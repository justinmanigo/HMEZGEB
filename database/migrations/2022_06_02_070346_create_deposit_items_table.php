<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepositItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deposit_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('deposit_id');
            $table->unsignedBigInteger('receipt_cash_transaction_id');
            $table->timestamps();

            $table->foreign('deposit_id')->references('id')->on('deposits');
            $table->foreign('receipt_cash_transaction_id')->references('id')->on('receipt_cash_transactions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deposit_items');
    }
}
