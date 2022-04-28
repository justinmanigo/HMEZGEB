<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str; 
class IncomeTaxPayrollRulesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('income_tax_payroll_rules')->insert([
            [
                'income' => 10900,
                'rate' => 35,
                'deduction' => 1500
            ],
            [
                'income' => 7800,
                'rate' => 30,
                'deduction' => 955
            ],
            [
                'income' => 5250,
                'rate' => 25,
                'deduction' => 565
            ],
            [
                'income' => 3200,
                'rate' => 20,
                'deduction' => 302.5
            ],
            [
                'income' => 1650,
                'rate' => 15,
                'deduction' => 142.5
            ],
            [
                'income' => 600,
                'rate' => 10,
                'deduction' => 60
            ],
        ]);
    }
}
