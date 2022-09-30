<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepositsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deposits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('accounting_system_id')->constrained();
            $table->unsignedBigInteger('chart_of_account_id');
            $table->enum('status',['Deposited','Void'])->default('Deposited');
            $table->date('deposit_ticket_date');
            $table->double('total_amount',8,2)->nullable();
            $table->string('remark')->nullable();
            $table->timestamps();
            $table->string('reference_number')->nullable();

            $table->foreign('chart_of_account_id')->references('id')->on('chart_of_accounts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deposits');
    }
}
