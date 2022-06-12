<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAccountingSystemsAddSettingsDefaults extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Update accounting_systems schema
        Schema::table('accounting_systems', function (Blueprint $table) {
            // Settings Inventory Type
            // Settings Defaults
            $table->foreignId('receipt_cash_on_hand')->nullable()->references('id')->on('chart_of_accounts');
            $table->foreignId('receipt_vat_payable')->nullable()->references('id')->on('chart_of_accounts');
            $table->foreignId('receipt_sales')->nullable()->references('id')->on('chart_of_accounts');
            $table->foreignId('receipt_account_receivable')->nullable()->references('id')->on('chart_of_accounts');
            $table->foreignId('receipt_sales_discount')->nullable()->references('id')->on('chart_of_accounts');
            $table->foreignId('receipt_withholding')->nullable()->references('id')->on('chart_of_accounts');

            $table->foreignId('advance_receipt_cash_on_hand')->nullable()->references('id')->on('chart_of_accounts');
            $table->foreignId('advance_receipt_advance_payment')->nullable()->references('id')->on('chart_of_accounts');

            $table->foreignId('credit_receipt_cash_on_hand')->nullable()->references('id')->on('chart_of_accounts');
            $table->foreignId('credit_receipt_account_receivable')->nullable()->references('id')->on('chart_of_accounts');

            $table->foreignId('bill_cash_on_hand')->nullable()->references('id')->on('chart_of_accounts');
            $table->foreignId('bill_items_for_sale')->nullable()->references('id')->on('chart_of_accounts');
            $table->foreignId('bill_freight_charge_expense')->nullable()->references('id')->on('chart_of_accounts');
            $table->foreignId('bill_vat_receivable')->nullable()->references('id')->on('chart_of_accounts');
            $table->foreignId('bill_account_payable')->nullable()->references('id')->on('chart_of_accounts');
            $table->foreignId('bill_withholding')->nullable()->references('id')->on('chart_of_accounts');

            $table->foreignId('payment_cash_on_hand')->nullable()->references('id')->on('chart_of_accounts');
            $table->foreignId('payment_vat_receivable')->nullable()->references('id')->on('chart_of_accounts');
            $table->foreignId('payment_account_payable')->nullable()->references('id')->on('chart_of_accounts');
            $table->foreignId('payment_withholding')->nullable()->references('id')->on('chart_of_accounts');
            $table->foreignId('payment_salary_payable')->nullable()->references('id')->on('chart_of_accounts');
            $table->foreignId('payment_commission_payment')->nullable()->references('id')->on('chart_of_accounts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
