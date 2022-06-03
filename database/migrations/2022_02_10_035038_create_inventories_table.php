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
            $table->foreignId('accounting_system_id')->constrained();
            $table->string('item_code');
            $table->string('item_name'); 
            $table->float('sale_price')->nullable();
            $table->float('purchase_price')->nullable();
            $table->integer('quantity')->nullable();
            $table->integer('critical_quantity')->nullable();
            // $table->float('sold_quantity')->nullable();
            // $table->float('purchase_quantity')->nullable();;
            $table->integer('tax_id')->nullable(); 
            $table->string('default_income_account')->nullable();
            $table->string('default_expense_account')->nullable();
            $table->enum('inventory_type',['inventory_item','non_inventory_item']);           
            $table->string('picture')->nullable();      
            $table->longText('description');
            $table->enum('is_enabled',['Yes','No'])->default('Yes');
            $table->enum('notify_critical_quantity',['Yes','No'])->default('Yes');
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
