<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('father_name');
            $table->string('given_father_name');
            $table->date('date_of_birth');
            $table->string('mobile_number');
            $table->string('telephone');  
            $table->string('email');   
            $table->string('tin_number');
            $table->enum('type',['employee','commision_agent']);
            $table->string('basic_salary');
            $table->date('date_started_working');
            // is this column type is it date or string
            // $table->date('date_ended_working')->default('still_working');
            $table->date('date_ended_working')->nullable();
            $table->string('emergency_contact_person');
            $table->string('contact_number');
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
        Schema::dropIfExists('employees');
    }
}
