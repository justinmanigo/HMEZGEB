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
            $table->unsignedBigInteger('payment_reference_id');
            $table->unsignedBigInteger('withholding_payment_id')->nullable();
            $table->date('due_date');
            $table->unsignedBigInteger('chart_of_account_id')->nullable();
            $table->float('sub_total');
            $table->float('discount')->nullable();;
            $table->float('tax')->nullable();;
            $table->float('grand_total');
            $table->float('withholding')->nullable();;
            $table->string('payment_method');            
            $table->float('amount_received');        
            $table->timestamps();    
            $table->foreign('payment_reference_id')->references('id')->on('payment_references');         
            $table->foreign('chart_of_account_id')->nullable()->references('id')->on('chart_of_accounts');
            $table->foreign('withholding_payment_id')->nullable()->references('id')->on('withholding_payments');
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
