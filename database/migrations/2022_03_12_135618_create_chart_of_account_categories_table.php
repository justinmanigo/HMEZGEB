<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChartOfAccountCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chart_of_account_categories', function (Blueprint $table) {
            $table->id();
            $table->string('category');
            $table->enum('type', [
                'Asset',
                'Capital',
                'Cost of sales',
                'Expense',
                'Liability',
                'Revenue',
            ]);
            $table->enum('normal_balance', [
                'Debit',
                'Credit',
            ]);
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
