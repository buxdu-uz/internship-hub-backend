<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = ['admin', 'teacher','company-representative','university-admin','regional-administration'];
        foreach ($roles as $role) {
           Role::updateOrCreate(['name' => $role]);
        }

        $admin = User::updateOrCreate([
            'login' => 'admin',
        ],[
            'firstname' => 'Admin',
            'lastname' => 'Adminov',
            'surname' => 'Adminovich',
            'password' => 'adminhub',
            'phone' => 998901234567,
            'birth' => 1930-02-02,
            'sex' => 'male',
            'organization' => 'Admin Organization',
        ]);

        $admin->assignRole($roles);
    }
}
