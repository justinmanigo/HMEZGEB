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
            $table->unsignedBigInteger('payment_reference_id');
            $table->date('due_date');
            $table->decimal('sub_total', 18, 8);
            $table->decimal('tax', 18, 8)->nullable();
            $table->decimal('grand_total', 18, 8);
            $table->timestamps();
            $table->foreign('payment_reference_id')->references('id')->on('payment_references'); 
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
