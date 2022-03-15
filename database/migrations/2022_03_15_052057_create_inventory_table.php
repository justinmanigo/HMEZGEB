<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory', function (Blueprint $table) {
            $table->id();
            $table->string('item_code');
            $table->string('item_name');
            $table->string('description');
            $table->string('sale_price');
            $table->float('purchase_price');
            $table->enum('inventory_type',['inventory_item','non_inventory_item']);
            $table->float('quantity');
            $table->string('default_income_account');
            $table->string('default_expense_account');
            $table->string('picture');
            $table->enum('is_enable',['Yes','No']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventory');
    }
}
