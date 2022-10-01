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
            $table->unsignedBigInteger('purchase_order_id')->nullable();
            $table->unsignedBigInteger('withholding_payment_id')->nullable();
            $table->date('due_date');
            $table->unsignedBigInteger('chart_of_account_id')->nullable();
            $table->decimal('sub_total', 18, 8);
            $table->decimal('discount', 18, 8)->nullable();
            $table->decimal('tax', 18, 8)->nullable();
            $table->decimal('grand_total', 18, 8);
            $table->decimal('withholding', 18, 8)->nullable();
            $table->enum('withholding_status', [
                'paid',
                'unpaid',
                'partially_paid',
            ]);
            $table->string('payment_method');            
            $table->decimal('amount_received', 18, 8);        
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
