<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Doctor as Doctor;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $names = [
            'Rena',
            'Gulu',
            'Nermin',
            'Terane',
            'Nigar',
            'Aza',
        ];

        foreach ($names as $name) {
            Doctor::factory()->create([
                'name' => $name,
            ]);
        }

    }
}
