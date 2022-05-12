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
                'firstName' => 'super',
                'lastName' => 'admin',
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
        ]);

        DB::table('accounting_system_users')->insert([
            [
                'accounting_system_id' => 1,
                'user_id' => 1,
                'role' => 'admin',
            ]
        ]);

        DB::table('permissions')->insert([
            ['user_id' => 1, 'accounting_system_id' => 1, 'access_level' => 'rw', 'sub_module_id' => 1],
            ['user_id' => 1, 'accounting_system_id' => 1, 'access_level' => 'rw', 'sub_module_id' => 2],
            ['user_id' => 1, 'accounting_system_id' => 1, 'access_level' => 'rw', 'sub_module_id' => 3],
            ['user_id' => 1, 'accounting_system_id' => 1, 'access_level' => 'rw', 'sub_module_id' => 4],
            ['user_id' => 1, 'accounting_system_id' => 1, 'access_level' => 'rw', 'sub_module_id' => 5],
            ['user_id' => 1, 'accounting_system_id' => 1, 'access_level' => 'rw', 'sub_module_id' => 6],
            ['user_id' => 1, 'accounting_system_id' => 1, 'access_level' => 'rw', 'sub_module_id' => 7],
            ['user_id' => 1, 'accounting_system_id' => 1, 'access_level' => 'rw', 'sub_module_id' => 8],
            ['user_id' => 1, 'accounting_system_id' => 1, 'access_level' => 'rw', 'sub_module_id' => 9],
            ['user_id' => 1, 'accounting_system_id' => 1, 'access_level' => 'rw', 'sub_module_id' => 10],
            ['user_id' => 1, 'accounting_system_id' => 1, 'access_level' => 'rw', 'sub_module_id' => 11],
            ['user_id' => 1, 'accounting_system_id' => 1, 'access_level' => 'rw', 'sub_module_id' => 12],
            ['user_id' => 1, 'accounting_system_id' => 1, 'access_level' => 'rw', 'sub_module_id' => 13],
            ['user_id' => 1, 'accounting_system_id' => 1, 'access_level' => 'rw', 'sub_module_id' => 14],
            ['user_id' => 1, 'accounting_system_id' => 1, 'access_level' => 'rw', 'sub_module_id' => 15],
            ['user_id' => 1, 'accounting_system_id' => 1, 'access_level' => 'rw', 'sub_module_id' => 16],
            ['user_id' => 1, 'accounting_system_id' => 1, 'access_level' => 'rw', 'sub_module_id' => 17],
            ['user_id' => 1, 'accounting_system_id' => 1, 'access_level' => 'rw', 'sub_module_id' => 18],
            ['user_id' => 1, 'accounting_system_id' => 1, 'access_level' => 'rw', 'sub_module_id' => 19],
        ]);
    }
}
