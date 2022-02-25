<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str; 
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    { 
        Role::insert([
            ['guard_name' => 'web', 'name' => 'Super Admin'],   // Super Admin
            ['guard_name' => 'web', 'name' => 'Admin'],         // Admin
            ['guard_name' => 'web', 'name' => 'Staff'],         // Manage Users
            ['guard_name' => 'web', 'name' => 'Member'],        // Profile
        ]);

        // To hide user's ability to see specific menu, it shall not have
        // either of the two permissions.
        Permission::insert([
            ['guard_name' => 'web', 'module' => 'Receipts',    'name' => 'Read Receipts'],
            ['guard_name' => 'web', 'module' => 'Receipts',    'name' => 'Read and Write Receipts']
        ]);

        // To insert some later ...
    }
}
