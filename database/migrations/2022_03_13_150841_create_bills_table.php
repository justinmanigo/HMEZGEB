<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->date('due_date');
            $table->unsignedBigInteger('vendor_id');
            $table->unsignedBigInteger('chart_of_account_id');
            $table->string('bill_number');
            $table->string('order_number');
            $table->float('sub_total');
            $table->float('discount');
            $table->float('tax');
            $table->float('grand_total');
            $table->float('withholding');
            $table->string('terms_and_conditions');
            $table->string('attachment')->nullable();
            $table->float('amount_received');
            $table->timestamps();

          
         

             $table->foreign('vendor_id')->references('id')->on('vendors');
             $table->foreign('chart_of_account_id')->references('id')->on('chart_of_accounts');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bills');
    }
}
