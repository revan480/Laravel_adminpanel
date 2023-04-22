<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Patient>
 */
class PatientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'surname' => $this->faker->name,
            'phone' => $this->faker->phoneNumber,
            'area' => $this->faker->city,
            'price' => $this->faker->randomNumber(3),
            'doctor_name' => $this->faker->name,
            'room_number' => $this->faker->randomNumber(3),
            'bill_type' => $this->faker->randomElement(['cash', $this->faker->name]),
            'feedback' => $this->faker->text,
            'date' => $this->faker->dateTime,
        ];
    }
}
