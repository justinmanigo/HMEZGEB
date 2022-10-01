<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreditReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('credit_receipts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('receipt_reference_id');
            $table->decimal('total_amount_received', 18, 8);
            $table->longText('description')->nullable();
            $table->longText('remark')->nullable();
            $table->string('attachment')->nullable();
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
        Schema::dropIfExists('credit_receipts');
    }
}
