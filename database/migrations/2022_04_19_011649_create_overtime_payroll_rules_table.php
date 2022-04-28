<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOvertimePayrollRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('overtime_payroll_rules', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable(); //? This is a temporary solution, may subject to change later.
            $table->string('working_days');
            $table->string('working_hours');
            $table->string('day_rate');
            $table->string('night_rate');
            $table->string('holiday_weekend_rate');
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
        Schema::dropIfExists('overtime_payroll_rules');
    }
}
