<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->float('item_code');
            $table->string('item_name'); 
            $table->string('sale_price');
            $table->float('purchase_price');
            $table->float('quantity');
            $table->enum('tax',['0%','2%','15%']); 
            $table->string('default_income_account')->nullable();
            $table->string('default_expense_account')->nullable();
            $table->enum('inventory_type',['inventory_item','non_inventory_item']);           
            $table->string('picture');      
            $table->longText('description');
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
        Schema::dropIfExists('inventories');
    }
}
