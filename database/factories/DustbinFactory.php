<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Dustbin>
 */
class DustbinFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'registration_number' => 'DUSTBIN/'.now()->year.'/'.now()->month.'/'. rand(111,999),
            'location' => $this->faker->city,
            'longitude' => $this->faker->longitude,
            'latitude' => $this->faker->latitude,
            'is_full' => false,
            'filling_percent' => rand(0,100),
            'is_active' => true,
            'user_id' => User::factory(),
        ];
    }
}
