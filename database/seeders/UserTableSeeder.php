<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str; 
use App\Actions\GenerateAccountingPeriods;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'email' => 'admin@email.com',
                'password' => Hash::make('test'),
                'username' => 'admin',
                'firstName' => 'hmezgeb',
                'lastName' => 'admin',
                'control_panel_role' => 'admin',
                'is_control_panel_access_accepted' => true,
                'must_update_password' => false,
                'code' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'email' => 'staff@email.com',
                'password' => Hash::make('test'),
                'username' => 'staff',
                'firstName' => 'hmezgeb',
                'lastName' => 'staff',
                'control_panel_role' => 'staff',
                'is_control_panel_access_accepted' => true,
                'must_update_password' => false,
                'code' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        $subscriptions = [
            [
                'user_id' => 1,
                'account_limit' => 10,
                'account_type' => 'super admin',
                'date_from' => null,
                'date_to' => null,
                'status' => 'active',
            ],
            [
                'user_id' => 2,
                'account_limit' => 10,
                'account_type' => 'super admin',
                'date_from' => null,
                'date_to' => null,
                'status' => 'active',
            ],
        ];

        $subscription_users = [
            [
                'subscription_id' => 1,
                'user_id' => 1,
                'role' => 'super admin',
            ],
            [
                'subscription_id' => 2,
                'user_id' => 2,
                'role' => 'super admin',
            ]
        ];

        $accounting_systems = [
            [
                'name' => 'Test Accounting System',
                'subscription_id' => 1,
                'calendar_type' => 'gregorian',
                'accounting_year' => 2022,
                'address' => 'Cebu',
                'city' => 'Cebu City',
                'country' => 'Philippines',
                'mobile_number' => '09123456789',
                'tin_number' => '12345',
                'contact_person' => 'PocketMaster',
                'contact_person_position' => 'Member',
                'contact_person_mobile_number' => '09123456789',
                'business_type' => 'PLC',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Test Accounting System 2',
                'subscription_id' => 2,
                'calendar_type' => 'ethiopian',
                'accounting_year' => 2014,
                'address' => 'Cebu',
                'city' => 'Cebu City',
                'country' => 'Philippines',
                'mobile_number' => '09123456789',
                'tin_number' => '12345',
                'contact_person' => 'PocketMaster',
                'contact_person_position' => 'Member',
                'contact_person_mobile_number' => '09123456789',
                'business_type' => 'Sole Proprietorship',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Test Accounting System 3',
                'subscription_id' => 2,
                'calendar_type' => 'gregorian',
                'accounting_year' => 2022,
                'address' => 'Cebu',
                'city' => 'Cebu City',
                'country' => 'Philippines',
                'mobile_number' => '09123456789',
                'tin_number' => '12345',
                'contact_person' => 'PocketMaster',
                'contact_person_position' => 'Member',
                'contact_person_mobile_number' => '09123456789',
                'business_type' => 'Sole Proprietorship',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        $accounting_system_users = [
            [
                'accounting_system_id' => 1,
                'subscription_user_id' => 1,
            ],
            [
                'accounting_system_id' => 2,
                'subscription_user_id' => 2,
            ],
            [
                'accounting_system_id' => 3,
                'subscription_user_id' => 2,
            ]
        ];

        $journal_entries = [
            [
                'date' => '2022-01-01',
                'notes' => 'Beginning Balance',
                'accounting_system_id' => 1,
            ],
            [
                'date' => '2022-01-01',
                'notes' => 'Beginning Balance',
                'accounting_system_id' => 2,
            ],
            [
                'date' => '2022-01-01',
                'notes' => 'Beginning Balance',
                'accounting_system_id' => 3,
            ],
        ];

        DB::table('users')->insert($users);
        DB::table('subscriptions')->insert($subscriptions);
        DB::table('subscription_users')->insert($subscription_users);
        DB::table('accounting_systems')->insert($accounting_systems);
        DB::table('accounting_system_users')->insert($accounting_system_users);
        DB::table('journal_entries')->insert($journal_entries);

        // Create withholding entry for Accounting System # 1
        DB::table('withholdings')->insert([
            [
                'accounting_system_id' => 1,
                'name' => 'Withholding',
                'percentage' => 2,
            ]
        ]);

        // Loop accounting systems
        for($i = 0; $i < count($accounting_systems); $i++)
        {
            GenerateAccountingPeriods::run($i+1, 
                $accounting_systems[$i]['calendar_type'],
                $accounting_systems[$i]['accounting_year'],
                $i+1);
        }

        // Loop users
        for($i = 1; $i <= 3; $i++)
        {
            $overtime_payroll_rules[] = [
                'accounting_system_id' => $i,
                'working_days' => 26,
                'working_hours' => 8,
                'day_rate' => 1.25,
                'night_rate' => 1.50,
                'holiday_weekend_rate' => 2.00
            ];

            // Loop permissions
            for($j = 1; $j <= 24; $j++)
            {
                $permissions[] = [
                    'accounting_system_user_id' => $i,
                    'access_level' => 'rw',
                    'sub_module_id' => $j,
                ];
            }

            DB::table('income_tax_payroll_rules')->insert([
                [
                    'accounting_system_id' => $i,
                    'income' => 10900,
                    'rate' => 35,
                    'deduction' => 1500
                ],
                [
                    'accounting_system_id' => $i,
                    'income' => 7800,
                    'rate' => 30,
                    'deduction' => 955
                ],
                [
                    'accounting_system_id' => $i,
                    'income' => 5250,
                    'rate' => 25,
                    'deduction' => 565
                ],
                [
                    'accounting_system_id' => $i,
                    'income' => 3200,
                    'rate' => 20,
                    'deduction' => 302.5
                ],
                [
                    'accounting_system_id' => $i,
                    'income' => 1650,
                    'rate' => 15,
                    'deduction' => 142.5
                ],
                [
                    'accounting_system_id' => $i,
                    'income' => 600,
                    'rate' => 10,
                    'deduction' => 60
                ],
            ]);
        }

        DB::table('permissions')->insert($permissions);
        DB::table('overtime_payroll_rules')->insert($overtime_payroll_rules);
    }
}
