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
        $names = [
            'Rena',
            'Gulu',
            'Nermin',
            'Terane',
            'Nigar',
            'Aza',
        ];
        // return fields by taking into consideration all the relationships
        return [
            'name' => $this->faker->firstName,
            'surname' => $this->faker->lastName,
            'phone' => $this->faker->phoneNumber,
            'area' => $this->faker->randomElement(['Baku', 'Sumqayit', 'Ganja', 'Shamkir', 'Quba', 'Qusar', 'Mingachevir', 'Astara', 'Agdam', 'Agdas', 'Agstafa', 'Agsu', 'Ali Bayramli', 'Astara', 'Babak', 'Balakan', 'Barda', 'Beylagan', 'Bilasuvar', 'Cabrayil', 'Calilabad', 'Daskasan', 'Davaci', 'Fuzuli', 'Gadabay', 'Ganca', 'Goranboy', 'Goycay', 'Haciqabul', 'Imisli', 'Ismayilli', 'Kalbacar', 'Kurdamir', 'Lacin', 'Lankaran', 'Lerik', 'Masalli', 'Mingacevir', 'Naftalan', 'Naxcivan', 'Neftcala', 'Oguz', 'Qabala', 'Qax', 'Qazax', 'Qobustan', 'Quba', 'Qubadli', 'Qusar', 'Saatli', 'Sabirabad', 'Saki', 'Salyan', 'Samaxi', 'Samkir', 'Samux', 'Siyazan', 'Sumqayit', 'Susa', 'Tartar', 'Tovuz', 'Ucar', 'Xacmaz', 'Xankandi', 'Xanlar', 'Xizi', 'Xocali', 'Xocavand', 'Yardimli', 'Yevlax', 'Zangilan', 'Zaqatala', 'Zardab']),
            'price' => $this->faker->randomElement([100, 200, 300, 400, 500, 600, 700, 800, 900, 1000]),
            'doctor_id' => $this->faker->numberBetween(1, 6),
            'room_id' => $this->faker->numberBetween(1,10),
            'bill_id' => $this->faker->numberBetween(1,2),
            'packet_id' => $this->faker->numberBetween(1,3),
            'feedback' => $this->faker->text(100),
            'date' => $this->faker->dateTimeBetween('-1 years', 'now'),
        ];
    }
}
