<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RegisterFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'gender' => $this->faker->randomElement(['Male', 'Female', 'Transgender']),
            'mobile' => $this->faker->numerify('##########'), // Generates a 10-digit number
            'email' => $this->faker->unique()->safeEmail,
            'address' => $this->faker->address,
            'state' => $this->faker->state,
            'district' => $this->faker->city,
            'pincode' => $this->faker->numerify('######'), // ✅ Generates exactly 6 digits
        ];
    }
}
