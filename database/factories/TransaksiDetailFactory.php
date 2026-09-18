<?php

namespace Database\Factories;

use App\Models\Obat;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TransaksiDetail>
 */
class TransaksiDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'transaksi_id' => Transaksi::factory(),
            'obat_id' => Obat::factory(),
            'qty' => 1,
            'harga_satuan' => 1000,
            'subtotal' => 1000,
        ];
    }
}
