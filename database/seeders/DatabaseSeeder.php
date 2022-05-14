<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        $this->call(ChartOfAccountCategoriesTableSeeder::class);
        $this->call(ModulesTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(IncomeTaxPayrollRulesSeeder::class);
        $this->call(OvertimePayrollRulesSeeder::class);
    }
}
