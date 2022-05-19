<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModulesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('modules')->insert([
            ['name' => 'customers'],        // id = 1
            ['name' => 'vendors'],          // id = 2
            ['name' => 'banking'],          // id = 3
            ['name' => 'journal voucher'],  // id = 4
            ['name' => 'human resource'],   // id = 5
            ['name' => 'inventory'],        // id = 6
            ['name' => 'reports'],         // id = 7
        ]);

        DB::table('sub_modules')->insert([
            // Customers
            ['module_id' => 1, 'name' => 'customers', 'url' => '/customers/customers/', 'duplicate_sub_module_id' => null],
            ['module_id' => 1, 'name' => 'receipts', 'url' => '/customers/receipts/', 'duplicate_sub_module_id' => null],
            ['module_id' => 1, 'name' => 'deposits', 'url' => '/customers/deposits/', 'duplicate_sub_module_id' => null],
            
            // Vendors
            ['module_id' => 2, 'name' => 'vendors', 'url' => '/vendors/vendors/', 'duplicate_sub_module_id' => null],
            ['module_id' => 2, 'name' => 'bills', 'url' => '/vendors/bills/', 'duplicate_sub_module_id' => null],
            ['module_id' => 2, 'name' => 'payments', 'url' => '/vendors/payments/', 'duplicate_sub_module_id' => null],

            // Banking
            ['module_id' => 3, 'name' => 'accounts', 'url' => '/banking/accounts/', 'duplicate_sub_module_id' => null],
            ['module_id' => 3, 'name' => 'transfer', 'url' => '/banking/transfer/', 'duplicate_sub_module_id' => null],
            ['module_id' => 3, 'name' => 'deposits', 'url' => '/banking/deposits/', 'duplicate_sub_module_id' => 3],
            ['module_id' => 3, 'name' => 'transactions', 'url' => '/banking/transactions/', 'duplicate_sub_module_id' => null],
            ['module_id' => 3, 'name' => 'bank reconcilation', 'url' => '/banking/reconcilation/', 'duplicate_sub_module_id' => null],

            // Journal Voucher
            ['module_id' => 4, 'name' => 'journal vouchers', 'url' => '/jv/', 'duplicate_sub_module_id' => null],

            // Human Resource
            ['module_id' => 5, 'name' => 'employees', 'url' => '/hr/employees/', 'duplicate_sub_module_id' => null],
            ['module_id' => 5, 'name' => 'payrolls', 'url' => '/hr/payrolls/', 'duplicate_sub_module_id' => null],
            ['module_id' => 5, 'name' => 'addition', 'url' => '/hr/addition/', 'duplicate_sub_module_id' => null],
            ['module_id' => 5, 'name' => 'deduction', 'url' => '/hr/deduction/', 'duplicate_sub_module_id' => null],
            ['module_id' => 5, 'name' => 'overtime', 'url' => '/hr/overtime/', 'duplicate_sub_module_id' => null],
            ['module_id' => 5, 'name' => 'loan', 'url' => '/hr/loan/', 'duplicate_sub_module_id' => null],

            // Inventory
            ['module_id' => 6, 'name' => 'inventory', 'url' => '/inventory/', 'duplicate_sub_module_id' => null],

            // Reports
            ['module_id' => 7, 'name' => 'customers', 'url' => '/reports/customers', 'duplicate_sub_module_id' => null],       
            ['module_id' => 7, 'name' => 'vendors', 'url' => '/reports/vendors', 'duplicate_sub_module_id' => null],       
            ['module_id' => 7, 'name' => 'sales', 'url' => '/reports/sales', 'duplicate_sub_module_id' => null],       
            ['module_id' => 7, 'name' => 'entries', 'url' => '/reports/entries', 'duplicate_sub_module_id' => null],       
            ['module_id' => 7, 'name' => 'financial statement', 'url' => '/reports/financial_statement', 'duplicate_sub_module_id' => null],       
        ]);
    }
}
