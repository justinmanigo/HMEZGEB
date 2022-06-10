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
            $table->foreignId('accounting_system_id')->constrained();
            $table->string('first_name');
            $table->string('father_name')->nullable();
            $table->string('grandfather_name')->nullable();
            $table->date('date_of_birth');
            $table->string('mobile_number');
            $table->string('telephone')->nullable();  
            $table->string('email')->nullable();   
            $table->string('tin_number')->nullable();
            $table->enum('type',['employee','commission_agent']);
            $table->string('basic_salary')->nullable();
            $table->date('date_started_working')->nullable();
            $table->date('date_ended_working')->nullable();
            $table->string('emergency_contact_person')->nullable();
            $table->string('emergency_contact_number')->nullable();
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