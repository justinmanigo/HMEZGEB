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
            $table->foreignId('chart_of_account_id')->constrained(); 
            $table->foreignId('accounting_period_id')->constrained();
            $table->decimal('beginning_balance', 18, 8)->nullable();
            $table->decimal('closing_balance', 18, 8)->nullable();
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
        Schema::dropIfExists('period_of_accounts');
    }
}
