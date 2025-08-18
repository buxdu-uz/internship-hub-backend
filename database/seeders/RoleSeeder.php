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
            'password' => 'adminhub',
            'is_active' => true,
        ]);
        $admin->profile()->updateOrCreate([
            'user_id' => $admin->id,
        ],[
            'firstname' => 'Admin',
            'lastname' => 'Adminov',
            'surname' => 'Adminovich',
            'phone' => 998901234567,
            'birth' => "1930-02-02",
            'sex' => 'male',
            'organization' => 'Admin Organization',
        ]);

//        $teacher_1 = User::updateOrCreate([
//            'login' => 'teacher',
//        ],[
//            'password' => 'teacher',
//            'is_active' => true,
//        ]);
//
//        $teacher_1->profile()->updateOrCreate([
//            'user_id' => $teacher_1->id,
//        ],[
//            'firstname' => 'Teacher',
//            'lastname' => 'Teacher',
//            'surname' => 'Teacher',
//            'phone' => 998901234568,
//            'birth' => "1930-02-02",
//            'sex' => 'male',
//            'organization' => 'Teacher Organization',
//        ]);
//
//        $company_representative_1 = User::updateOrCreate([
//            'login' => 'company-representative',
//        ],[
//            'password' => 'company-representative',
//            'is_active' => true,
//        ]);
//
//        $company_representative_1->profile()->updateOrCreate([
//            'user_id' => $company_representative_1->id,
//        ],[
//            'firstname' => 'Korxona 1',
//            'lastname' => 'korxona',
//            'surname' => 'Korxona',
//            'phone' => 998901234569,
//            'birth' => "1930-02-02",
//            'sex' => 'male',
//            'organization' => 'Korxona Organization',
//        ]);
//
//        $teacher_2 = User::updateOrCreate([
//            'login' => 'teacher_2',
//        ],[
//            'password' => 'teacher',
//            'is_active' => true,
//        ]);
//
//        $teacher_2->profile()->updateOrCreate([
//            'user_id' => $teacher_2->id,
//        ],[
//            'firstname' => 'Teacher_2',
//            'lastname' => 'Teacher_2',
//            'surname' => 'Teacher_2',
//            'phone' => 998901234560,
//            'birth' => "1930-02-02",
//            'sex' => 'male',
//            'organization' => 'Teacher 2 Organization',
//        ]);
//
//        $company_representative_2 = User::updateOrCreate([
//            'login' => 'company-representative-2',
//        ],[
//            'password' => 'company-representative',
//            'is_active' => true,
//        ]);
//
//        $company_representative_2->profile()->updateOrCreate([
//            'user_id' => $company_representative_2->id,
//        ],[
//            'firstname' => 'Korxona 2',
//            'lastname' => 'korxona 2',
//            'surname' => 'Korxona 2',
//            'phone' => 998901234561,
//            'birth' => "1930-02-02",
//            'sex' => 'male',
//            'organization' => 'Korxona 2 Organization',
//        ]);

        $admin->assignRole($roles);
//        $teacher_1->assignRole('teacher');
//        $teacher_2->assignRole('teacher');
//        $company_representative_1->assignRole('company-representative');
//        $company_representative_2->assignRole('company-representative');
    }
}
