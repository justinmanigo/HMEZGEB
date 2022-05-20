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
            $table->string('chart_of_account_category_id');
            $table->string('chart_of_account_no');
            $table->string('name');
            $table->string('bank_account_number')->nullable();
            $table->string('bank_branch')->nullable(); 
            $table->string('bank_account_type')->nullable(); 
            $table->float('current_balance')->nullable(); 
            $table->enum('status',['Active','Closed'])->default('Active');
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
