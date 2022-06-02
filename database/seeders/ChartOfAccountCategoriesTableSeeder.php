<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str; 
class ChartOfAccountCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('chart_of_account_categories')->insert([
            // Asset
            [
                'category' => 'Cash',
                'type' => 'Asset',
                'normal_balance' => 'Debit'
            ],
            [
                'category' => 'Account Receivable',
                'type' => 'Asset',
                'normal_balance' => 'Debit'
            ],
            [
                'category' => 'Accumulated Depreciation',
                'type' => 'Asset',
                'normal_balance' => 'Credit',
            ],
            [
                'category' => 'Fixed Asset',
                'type' => 'Asset',
                'normal_balance' => 'Debit',
            ],
            [
                'category' => 'Inventory',
                'type' => 'Asset',
                'normal_balance' => 'Debit',
            ],
            [
                'category' => 'Other Current Asset',
                'type' => 'Asset',
                'normal_balance' => 'Debit',
            ],
            // Capital
            [
                'category' => "Equity-doesn't Closed",
                'type' => 'Capital',
                'normal_balance' => 'Credit',
            ],
            [
                'category' => 'Equity-Retained Earning',
                'type' => 'Capital',
                'normal_balance' => 'Credit',
            ],
            [
                'category' => 'Equity-gets Closed',
                'type' => 'Capital',
                'normal_balance' => 'Credit',
            ],
            // Cost of Sales
            [
                'category' => 'Cost of Goods Sold',
                'type' => 'Cost of Sales',
                'normal_balance' => 'Debit',
            ],
            // Expense
            [
                'category' => 'Expense',
                'type' => 'Expense',
                'normal_balance' => 'Debit',
            ],
            // Liability
            [
                'category' => 'Account Payable',
                'type' => 'Liability',
                'normal_balance' => 'Credit',
            ],
            [
                'category' => 'Long Term Liability',
                'type' => 'Liability',
                'normal_balance' => 'Credit',
            ],
            [
                'category' => 'Other Current Liability',
                'type' => 'Liability',
                'normal_balance' => 'Credit',
            ],
            // Revenue
            [
                'category' => 'Sales',
                'type' => 'Revenue',
                'normal_balance' => 'Credit'
            ],
            [
                'category' => 'Other Income / Gain',
                'type' => 'Revenue',
                'normal_balance' => 'Credit',
            ],
            [
                'category' => 'Sales Return',
                'type' => 'Revenue',
                'normal_balance' => 'Debit',
            ],
        ]);
    }
}
