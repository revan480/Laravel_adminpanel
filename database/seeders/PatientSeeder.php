<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 10 patients
        \App\Models\Patient::factory()->count(50)->create();

    }
}
