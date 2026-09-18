<?php

namespace Database\Seeders;

use App\Models\Obat;
use Illuminate\Database\Seeder;

class ObatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Obat::query()->upsert([
            ['kode_obat' => 'OBT-001', 'nama_obat' => 'Paracetamol 500 mg', 'satuan_obat' => 'Tablet', 'harga_obat' => 1500, 'stok_obat' => 100],
            ['kode_obat' => 'OBT-002', 'nama_obat' => 'Amoxicillin 500 mg', 'satuan_obat' => 'Kapsul', 'harga_obat' => 2500, 'stok_obat' => 80],
            ['kode_obat' => 'OBT-003', 'nama_obat' => 'Cetirizine 10 mg', 'satuan_obat' => 'Tablet', 'harga_obat' => 1800, 'stok_obat' => 75],
            ['kode_obat' => 'OBT-004', 'nama_obat' => 'Vitamin C 500 mg', 'satuan_obat' => 'Tablet', 'harga_obat' => 1200, 'stok_obat' => 150],
            ['kode_obat' => 'OBT-005', 'nama_obat' => 'Antasida', 'satuan_obat' => 'Botol', 'harga_obat' => 8500, 'stok_obat' => 40],
        ], ['kode_obat'], ['nama_obat', 'satuan_obat', 'harga_obat', 'stok_obat']);
    }
}
