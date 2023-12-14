<?php

namespace Database\Seeders;

use App\Models\AppointmentStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AppointmentStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AppointmentStatus::create(['id' => AppointmentStatus::CANCELED, 'name' => 'Cancelado']);
        AppointmentStatus::create(['id' => AppointmentStatus::COMPLETED, 'name' => 'Concluido']);
        AppointmentStatus::create(['id' => AppointmentStatus::SCHEDULED, 'name' => 'Marcada']);
    }
}
