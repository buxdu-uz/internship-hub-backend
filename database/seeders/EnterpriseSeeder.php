<?php

namespace Database\Seeders;

use App\Models\Enterprise;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EnterpriseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Enterprise::create([
            'name' => 'Tech Innovators Inc.',
            'description' => 'A leading company in technology solutions and innovations.',
            'location' => 'Silicon Valley, CA'
        ]);

        Enterprise::create([
            'name' => 'Buxdu.',
            'description' => 'A leading company in technology solutions and innovations.',
            'location' => 'Bukhara, Uzbekistan'
        ]);
    }
}
