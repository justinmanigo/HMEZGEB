<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceiptReferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receipt_references', function (Blueprint $table) {
            $table->id();
            $table->foreignId('accounting_system_id')->constrained();
            $table->unsignedBigInteger('customer_id');
            $table->date('date');
            $table->enum('type',['receipt','credit_receipt','advance_receipt','proforma','sale']);
            $table->enum('status',['unpaid','partially_paid','paid']);
            $table->enum('is_deposited',['no','yes'])->default('no');
            $table->enum('is_void',['yes','no'])->default('no');
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('customers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('receipt_references');
    }
}
