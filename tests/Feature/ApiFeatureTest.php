<?php

namespace Tests\Feature;

use App\Models\Obat;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ApiFeatureTest extends TestCase
{
    use DatabaseTransactions;

    public function test_stock_and_order_apis_return_data_and_update_stock(): void
    {
        $obat = Obat::factory()->create(['nama_obat' => 'API Obat', 'stok_obat' => 10, 'harga_obat' => 3000]);

        $this->getJson('/api/obat?q=API')->assertOk()->assertJsonPath('success', true)->assertJsonPath('data.0.id_obat', $obat->id_obat);
        $this->getJson('/api/obat/'.$obat->id_obat)->assertOk()->assertJsonPath('data.stok_obat', 10);
        $response = $this->postJson('/api/pesanan', ['nama_pembeli' => 'API Buyer', 'items' => [['obat_id' => $obat->id_obat, 'qty' => 2]]]);
        $response->assertCreated()->assertJsonPath('success', true)->assertJsonPath('data.total', 6000);
        $this->assertDatabaseHas('obat', ['id_obat' => $obat->id_obat, 'stok_obat' => 8]);
    }

    public function test_order_api_rolls_back_when_stock_is_insufficient(): void
    {
        $obat = Obat::factory()->create(['stok_obat' => 1]);

        $this->postJson('/api/pesanan', ['items' => [['obat_id' => $obat->id_obat, 'qty' => 2]]])
            ->assertUnprocessable()
            ->assertJsonPath('success', false);
        $this->assertDatabaseHas('obat', ['id_obat' => $obat->id_obat, 'stok_obat' => 1]);
    }
}
