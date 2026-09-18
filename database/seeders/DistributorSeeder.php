<?php

namespace Database\Seeders;

use App\Models\Distributor;
use Illuminate\Database\Seeder;

class DistributorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Distributor::query()->upsert([
            ['nama_distributor' => 'PT Kimia Farma', 'alamat' => 'Jl. Veteran No. 1', 'kota' => 'Jakarta', 'telepon' => '021-1234567', 'email' => 'info@kimiafarma.co.id', 'latitude' => -6.1751, 'longitude' => 106.8650],
            ['nama_distributor' => 'PT Anugerah Medika', 'alamat' => 'Jl. Asia Afrika No. 8', 'kota' => 'Bandung', 'telepon' => '022-2345678', 'email' => 'halo@anugerahmedika.id', 'latitude' => -6.9175, 'longitude' => 107.6191],
            ['nama_distributor' => 'CV Sehat Sentosa', 'alamat' => 'Jl. Pemuda No. 12', 'kota' => 'Surabaya', 'telepon' => '031-3456789', 'email' => 'sales@sehatsentosa.id', 'latitude' => -7.2575, 'longitude' => 112.7521],
            ['nama_distributor' => 'PT Nusantara Farma', 'alamat' => 'Jl. Sudirman No. 20', 'kota' => 'Yogyakarta', 'telepon' => '0274-456789', 'email' => 'info@nusantarafarma.id', 'latitude' => -7.7956, 'longitude' => 110.3695],
            ['nama_distributor' => 'CV Prima Medis', 'alamat' => 'Jl. Gajah Mada No. 5', 'kota' => 'Denpasar', 'telepon' => '0361-567890', 'email' => 'kontak@primamedis.id', 'latitude' => -8.6705, 'longitude' => 115.2126],
        ], ['nama_distributor'], ['alamat', 'kota', 'telepon', 'email', 'latitude', 'longitude']);
    }
}
