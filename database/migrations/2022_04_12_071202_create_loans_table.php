<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('accounting_system_id')->constrained();
            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('payroll_id')->nullable();
            $table->date('date');
            $table->decimal('loan', 18, 8)->default(0);
            $table->string('paid_in');
            $table->string('description')->nullable();
            $table->string('type')->default('loan');
            $table->enum('status',['pending','paid','cancelled'])->default('pending');
            $table->foreign('payroll_id')->references('id')->on('payrolls');

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
        Schema::dropIfExists('loans');
    }
}