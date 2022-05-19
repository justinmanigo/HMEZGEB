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

        DB::table('permissions')->insert([
            // User Account 1
            ['accounting_system_user_id' => 1, 'access_level' => 'rw', 'sub_module_id' => 1],
            ['accounting_system_user_id' => 1, 'access_level' => 'rw', 'sub_module_id' => 2],
            ['accounting_system_user_id' => 1, 'access_level' => 'rw', 'sub_module_id' => 3],
            ['accounting_system_user_id' => 1, 'access_level' => 'rw', 'sub_module_id' => 4],
            ['accounting_system_user_id' => 1, 'access_level' => 'rw', 'sub_module_id' => 5],
            ['accounting_system_user_id' => 1, 'access_level' => 'rw', 'sub_module_id' => 6],
            ['accounting_system_user_id' => 1, 'access_level' => 'rw', 'sub_module_id' => 7],
            ['accounting_system_user_id' => 1, 'access_level' => 'rw', 'sub_module_id' => 8],
            ['accounting_system_user_id' => 1, 'access_level' => 'rw', 'sub_module_id' => 9],
            ['accounting_system_user_id' => 1, 'access_level' => 'rw', 'sub_module_id' => 10],
            ['accounting_system_user_id' => 1, 'access_level' => 'rw', 'sub_module_id' => 11],
            ['accounting_system_user_id' => 1, 'access_level' => 'rw', 'sub_module_id' => 12],
            ['accounting_system_user_id' => 1, 'access_level' => 'rw', 'sub_module_id' => 13],
            ['accounting_system_user_id' => 1, 'access_level' => 'rw', 'sub_module_id' => 14],
            ['accounting_system_user_id' => 1, 'access_level' => 'rw', 'sub_module_id' => 15],
            ['accounting_system_user_id' => 1, 'access_level' => 'rw', 'sub_module_id' => 16],
            ['accounting_system_user_id' => 1, 'access_level' => 'rw', 'sub_module_id' => 17],
            ['accounting_system_user_id' => 1, 'access_level' => 'rw', 'sub_module_id' => 18],
            ['accounting_system_user_id' => 1, 'access_level' => 'rw', 'sub_module_id' => 19],
            // User Account 2 System 1
            ['accounting_system_user_id' => 2, 'access_level' => 'rw', 'sub_module_id' => 1],
            ['accounting_system_user_id' => 2, 'access_level' => 'rw', 'sub_module_id' => 2],
            ['accounting_system_user_id' => 2, 'access_level' => 'rw', 'sub_module_id' => 3],
            ['accounting_system_user_id' => 2, 'access_level' => 'rw', 'sub_module_id' => 4],
            ['accounting_system_user_id' => 2, 'access_level' => 'rw', 'sub_module_id' => 5],
            ['accounting_system_user_id' => 2, 'access_level' => 'rw', 'sub_module_id' => 6],
            ['accounting_system_user_id' => 2, 'access_level' => 'rw', 'sub_module_id' => 7],
            ['accounting_system_user_id' => 2, 'access_level' => 'rw', 'sub_module_id' => 8],
            ['accounting_system_user_id' => 2, 'access_level' => 'rw', 'sub_module_id' => 9],
            ['accounting_system_user_id' => 2, 'access_level' => 'rw', 'sub_module_id' => 10],
            ['accounting_system_user_id' => 2, 'access_level' => 'rw', 'sub_module_id' => 11],
            ['accounting_system_user_id' => 2, 'access_level' => 'rw', 'sub_module_id' => 12],
            ['accounting_system_user_id' => 2, 'access_level' => 'rw', 'sub_module_id' => 13],
            ['accounting_system_user_id' => 2, 'access_level' => 'rw', 'sub_module_id' => 14],
            ['accounting_system_user_id' => 2, 'access_level' => 'rw', 'sub_module_id' => 15],
            ['accounting_system_user_id' => 2, 'access_level' => 'rw', 'sub_module_id' => 16],
            ['accounting_system_user_id' => 2, 'access_level' => 'rw', 'sub_module_id' => 17],
            ['accounting_system_user_id' => 2, 'access_level' => 'rw', 'sub_module_id' => 18],
            ['accounting_system_user_id' => 2, 'access_level' => 'rw', 'sub_module_id' => 19],
            // User Account 2 System 2
            ['accounting_system_user_id' => 3, 'access_level' => 'rw', 'sub_module_id' => 1],
            ['accounting_system_user_id' => 3, 'access_level' => 'rw', 'sub_module_id' => 2],
            ['accounting_system_user_id' => 3, 'access_level' => 'rw', 'sub_module_id' => 3],
            ['accounting_system_user_id' => 3, 'access_level' => 'rw', 'sub_module_id' => 4],
            ['accounting_system_user_id' => 3, 'access_level' => 'rw', 'sub_module_id' => 5],
            ['accounting_system_user_id' => 3, 'access_level' => 'rw', 'sub_module_id' => 6],
            ['accounting_system_user_id' => 3, 'access_level' => 'rw', 'sub_module_id' => 7],
            ['accounting_system_user_id' => 3, 'access_level' => 'rw', 'sub_module_id' => 8],
            ['accounting_system_user_id' => 3, 'access_level' => 'rw', 'sub_module_id' => 9],
            ['accounting_system_user_id' => 3, 'access_level' => 'rw', 'sub_module_id' => 10],
            ['accounting_system_user_id' => 3, 'access_level' => 'rw', 'sub_module_id' => 11],
            ['accounting_system_user_id' => 3, 'access_level' => 'rw', 'sub_module_id' => 12],
            ['accounting_system_user_id' => 3, 'access_level' => 'rw', 'sub_module_id' => 13],
            ['accounting_system_user_id' => 3, 'access_level' => 'rw', 'sub_module_id' => 14],
            ['accounting_system_user_id' => 3, 'access_level' => 'rw', 'sub_module_id' => 15],
            ['accounting_system_user_id' => 3, 'access_level' => 'rw', 'sub_module_id' => 16],
            ['accounting_system_user_id' => 3, 'access_level' => 'rw', 'sub_module_id' => 17],
            ['accounting_system_user_id' => 3, 'access_level' => 'rw', 'sub_module_id' => 18],
            ['accounting_system_user_id' => 3, 'access_level' => 'rw', 'sub_module_id' => 19],
        ]);
    }
}
