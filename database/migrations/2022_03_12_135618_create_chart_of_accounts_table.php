<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChartOfAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chart_of_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('chart_of_account_no');
            $table->string('name');
            $table->string('category');
            $table->string('account_type');
            $table->string('bank_account_number');
            $table->string('bank_branch'); 
            $table->string('bank_account_type'); 
            $table->float('current_balance'); 
            $table->enum('status',['active','closed'])->default('active');
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
        Schema::dropIfExists('chart_of_accounts');
    }
}
