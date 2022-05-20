<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str; 
class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
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
        ]);

        DB::table('accounting_systems')->insert([
            [
                'name' => 'Test Accounting System',
                'calendar_type' => 'gregorian',
                'calendar_type_view' => 'gregorian',
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
                'calendar_type' => 'gregorian',
                'calendar_type_view' => 'gregorian',
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
                'calendar_type_view' => 'gregorian',
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
        ]);

        DB::table('accounting_system_users')->insert([
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
        ]);

        // Loop accounting systems
        for($i = 1; $i <= 3; $i++)
        {
            // Setup accounting period for each accounting system
            $accounting_period[] = [
                'accounting_system_id' => $i,
                'period_number' => 1,
                'date_from' => '2022-05-01',
                'date_to' => '2022-05-31',
                'date_from_ethiopian' => '2014-08-23',
                'date_to_ethiopian' => '2014-09-23',
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // Loop months
            for($j = 1; $j <= 12; $j++)
            {
                // Gregorian Months
                switch($j)
                {
                    case 1:     $day = 31; $day_leap = 31; break;
                    case 2:     $day = 28; $day_leap = 29; break;
                    case 3:     $day = 31; $day_leap = 31; break;
                    case 4:     $day = 30; $day_leap = 30; break;
                    case 5:     $day = 31; $day_leap = 31; break;
                    case 6:     $day = 30; $day_leap = 30; break;
                    case 7:     $day = 31; $day_leap = 31; break;
                    case 8:     $day = 31; $day_leap = 31; break;
                    case 9:     $day = 30; $day_leap = 30; break;
                    case 10:    $day = 31; $day_leap = 31; break;
                    case 11:    $day = 30; $day_leap = 30; break;
                    case 12:    $day = 31; $day_leap = 31; break;
                }

                // Create period settings row
                $period_settings[] = [
                    'accounting_system_id' => $i,
                    // Date From
                    'month_from' => $j,
                    'day_from' => 1,
                    // Date To
                    'month_to' => $j,
                    'day_to' => $day,
                    // Date From Leap
                    'month_from_leap' => $j,
                    'day_from_leap' => 1,
                    // Date To Leap
                    'month_to_leap' => $j,
                    'day_to_leap' => $day_leap,
                    // TODO: Ethiopian Date Support Later
                    // User ID
                    'accounting_system_user_id' => $i,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }


        DB::table('period_settings')->insert($period_settings);

        DB::table('accounting_periods')->insert($accounting_period);

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
