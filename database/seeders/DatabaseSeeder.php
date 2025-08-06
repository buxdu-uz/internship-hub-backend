<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            UniversitySeeder::class,
            RoleSeeder::class,
            EnterpriseSeeder::class
            // UserSeeder::class, // Uncomment if you have a UserSeeder
            // Other seeders can be added here
        ]);
    }
}
