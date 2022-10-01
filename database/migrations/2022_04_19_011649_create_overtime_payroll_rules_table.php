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
            $table->foreignId('accounting_system_id')->constrained();
            $table->integer('working_days');
            $table->integer('working_hours');
            $table->decimal('day_rate', 5, 2);
            $table->decimal('night_rate', 5, 2);
            $table->decimal('holiday_weekend_rate', 5, 2);
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
