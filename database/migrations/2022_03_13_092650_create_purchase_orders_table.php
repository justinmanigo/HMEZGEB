<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vendor_id');
            $table->date('date');
            $table->string('order_number');
            $table->date('due_date');
            $table->float('sub_total');
            $table->float('tax');
            $table->float('grand_total');
            $table->longText('terms_and_conditions');
            $table->string('attachment');
            $table->timestamps();

            $table->foreign('vendor_id')->references('id')->on('vendors'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase_orders');
    }
}
