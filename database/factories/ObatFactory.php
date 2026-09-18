<?php

namespace Database\Factories;

use App\Models\Obat;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Obat>
 */
class ObatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'kode_obat' => fake()->unique()->bothify('OBT-###'),
            'nama_obat' => fake()->words(3, true),
            'satuan_obat' => fake()->randomElement(['Tablet', 'Kapsul', 'Botol']),
            'harga_obat' => fake()->randomFloat(2, 500, 50000),
            'stok_obat' => fake()->numberBetween(10, 200),
        ];
    }
}
