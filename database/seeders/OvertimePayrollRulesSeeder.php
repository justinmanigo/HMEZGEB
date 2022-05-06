<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str; 

class OvertimePayrollRulesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('overtime_payroll_rules')->insert([
            [
                'user_id' => 1,
                'working_days' => 26,
                'working_hours' => 8,
                'day_rate' => 1.25,
                'night_rate' => 1.50,
                'holiday_weekend_rate' => 2.00
            ],
        ]);
    }
}
