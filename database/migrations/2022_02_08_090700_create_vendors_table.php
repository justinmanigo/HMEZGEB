<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('tin_number')->unique()->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->string('mobile_number')->nullable(); 
            $table->string('telephone_one')->nullable();
            $table->string('telephone_two')->nullable();
            $table->string('fax')->nullable();   
            $table->string('website')->nullable();   
            $table->string('email')->nullable();   
            $table->string('contact_person')->nullable();
            $table->string('label')->nullable();
            $table->string('image')->nullable();
            $table->enum('is_active',['Yes','No'])->default('Yes')->nullable();


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
        Schema::dropIfExists('vendors');
    }
}
