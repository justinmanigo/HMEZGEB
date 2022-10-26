<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('receipt_reference_id');
            $table->string('reference_number')->nullable();
            $table->decimal('price', 18, 8);
            $table->decimal('withholding', 18, 8);
            $table->decimal('tax', 18, 8);
            $table->decimal('grand_total', 18, 8);
            $table->decimal('amount_received', 18, 8);
            $table->longText('terms_and_conditions')->nullable();
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
        Schema::dropIfExists('sales');
    }
}
