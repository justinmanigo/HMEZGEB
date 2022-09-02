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
            $table->unsignedBigInteger('proforma_id')->nullable();
            $table->foreignid('chart_of_account_id')->nullable()->constrained();
            $table->date('due_date');
            $table->float('sub_total');
            $table->float('discount')->nullable();
            $table->float('tax')->nullable();
            $table->float('grand_total');
            $table->float('total_amount_received');
            $table->float('withholding')->nullable();
            $table->longText('remark')->nullable();
            $table->string('attachment')->nullable();
            $table->enum('payment_method',['credit','cash']);
            $table->foreignId('employee_id')->nullable(); // Commission Agent
            $table->timestamps();
            $table->foreign('receipt_reference_id')->references('id')->on('receipt_references');
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
