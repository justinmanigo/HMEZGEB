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
                'code' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        $accounting_systems = [
            [
                'name' => 'Test Accounting System',
                'calendar_type' => 'gregorian',
                'accounting_year' => 2022,
                'address' => 'Cebu',
                'city' => 'Cebu City',
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
                'name' => 'Test Accounting System 2',
                'calendar_type' => 'ethiopian',
                'accounting_year' => 2014,
                'address' => 'Cebu',
                'city' => 'Cebu City',
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
                'calendar_type' => 'gregorian',
                'accounting_year' => 2022,
                'address' => 'Cebu',
                'city' => 'Cebu City',
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
                'user_id' => 1,
                'role' => 'admin',
            ],
            [
                'accounting_system_id' => 2,
                'user_id' => 2,
                'role' => 'admin',
            ],
            [
                'accounting_system_id' => 3,
                'user_id' => 2,
                'role' => 'admin',
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
        DB::table('accounting_systems')->insert($accounting_systems);
        DB::table('accounting_system_users')->insert($accounting_system_users);
        DB::table('journal_entries')->insert($journal_entries);

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
            // Loop permissions
            for($j = 1; $j <= 24; $j++)
            {
                $permissions[] = [
                    'accounting_system_user_id' => $i,
                    'access_level' => 'rw',
                    'sub_module_id' => $j,
                ];
            }
        }

        DB::table('permissions')->insert($permissions);
    }
}
