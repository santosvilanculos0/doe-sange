<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Santos Vilanculos',
            'email' => 'test@example.com',
            'is_admin' => true,
        ]);

        \App\Models\Branch::factory(10)->create();

        $this->call([BloodTypeSeeder::class, AppointmentStatusSeeder::class]);
    }
}
