<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receipts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('receipt_reference_id');
            $table->unsignedBigInteger('proforma_id');
            $table->string('receipt_number');
            $table->date('due_date');
            $table->float('sub_total');
            $table->float('discount');
            $table->float('tax');
            $table->float('grand_total');
            $table->float('witholding');
            $table->longText('remark')->nullable();
            $table->string('attachement');
            $table->enum('payment_method',['credit','debit']);
            $table->timestamps();
            $table->foreign('receipt_reference_id')->references('id')->on('receipt_references');
            $table->foreign('proforma_id')->references('id')->on('proformas');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('receipts');
    }
}
