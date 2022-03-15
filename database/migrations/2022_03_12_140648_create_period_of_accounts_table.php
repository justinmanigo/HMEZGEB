<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeriodOfAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('period_of_accounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('chart_of_account_id'); 
            $table->unsignedBigInteger('accounting_period_id');
            $table->float('beggining_balance');
            $table->float('closing_balance');
            $table->timestamps();

              $table->foreign('chart_of_account_id')->references('id')->on('chart_of_accounts');
              $table->foreign('accounting_period_id')->references('id')->on('accounting_periods');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('period_of_accounts');
    }
}
