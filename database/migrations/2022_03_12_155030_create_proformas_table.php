<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProformasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proformas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('receipt_reference_id');
            $table->string('proforma_number');
            $table->date('due_date');
            $table->float('amount');
            $table->longText('terms_and_conditions');
            $table->string('attachement');
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
        Schema::dropIfExists('proformas');
    }
}
