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
                'category' => 'Sales',
                'type' => 'Revenue',
                'normal_balance' => 'Credit'
            ],
            [
                'category' => 'Other Current Liability',
                'type' => 'Liability',
                'normal_balance' => 'Credit'
            ]
        ]);
    }
}
