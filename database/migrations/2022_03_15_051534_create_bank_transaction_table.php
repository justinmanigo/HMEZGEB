<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBankTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_transaction', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('account');
            $table->string('type');
            $table->string('description');
            $table->float('amount');
            $table->unsignedBigInteger('bank_reconciliations_id');
            $table->timestamps();

            $table->foreign('bank_reconciliations_id')->references('id')->on('bank_reconciliations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bank_transaction');
    }
}
