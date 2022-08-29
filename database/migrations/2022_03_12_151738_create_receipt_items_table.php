<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceiptItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receipt_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('inventory_id');
            $table->unsignedBigInteger('receipt_reference_id'); 
            $table->integer('quantity'); 
            $table->float('price')->nullable();
            $table->float('total_price')->nullable();
            $table->timestamps();

            $table->foreign('inventory_id')->references('id')->on('inventories');
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
        Schema::dropIfExists('receipt_items');
    }
}
