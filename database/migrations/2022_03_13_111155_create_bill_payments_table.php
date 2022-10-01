<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bill_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('payment_reference_id');
            $table->unsignedBigInteger('chart_of_account_id')->nullable();
            $table->string('cheque_number')->nullable();
            $table->float('discount_account_number')->nullable();
            $table->decimal('amount_paid');
            $table->timestamps();
            $table->foreign('payment_reference_id')->references('id')->on('payment_references');
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
        Schema::dropIfExists('bill_payments');
    }
}
