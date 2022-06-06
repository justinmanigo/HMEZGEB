<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('accounting_system_id')->constrained();
            $table->string('name');
            $table->string('tin_number')->nullable();;
            $table->longText('address');
            $table->string('city');
            $table->string('country');
            $table->string('mobile_number'); 
            $table->string('telephone_one');
            $table->string('telephone_two')->nullable();
            $table->string('fax')->nullable();;   
            $table->string('website')->nullable();;   
            $table->string('email');   
            $table->string('contact_person');
            $table->string('image')->nullable();
            $table->string('label');
            $table->enum('is_active',['Yes','No'])->default('Yes');
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
        Schema::dropIfExists('customers');
    }
}
