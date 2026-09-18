<?php

namespace Database\Factories;

use App\Models\Distributor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Distributor>
 */
class DistributorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama_distributor' => fake()->unique()->company(),
            'alamat' => fake()->address(),
            'kota' => fake()->city(),
            'telepon' => fake()->phoneNumber(),
            'email' => fake()->unique()->safeEmail(),
            'latitude' => fake()->randomFloat(6, -8, -6),
            'longitude' => fake()->randomFloat(6, 106, 115),
        ];
    }
}
