<?php

namespace Tests\Feature;

use App\Models\Obat;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ObatFeatureTest extends TestCase
{
    use DatabaseTransactions;

    public function test_user_can_create_view_update_and_delete_obat(): void
    {
        $response = $this->post(route('obat.store'), [
            'kode_obat' => 'OBT-TEST',
            'nama_obat' => 'Obat Test',
            'satuan_obat' => 'Tablet',
            'harga_obat' => 2500,
            'stok_obat' => 20,
        ]);

        $obat = Obat::query()->where('kode_obat', 'OBT-TEST')->firstOrFail();

        $response->assertRedirect(route('obat.index'));
        $this->get(route('obat.index'))->assertOk()->assertSee('Obat Test');

        $this->put(route('obat.update', $obat), [
            'kode_obat' => 'OBT-TEST',
            'nama_obat' => 'Obat Test Updated',
            'satuan_obat' => 'Kapsul',
            'harga_obat' => 3000,
            'stok_obat' => 25,
        ])->assertRedirect(route('obat.index'));

        $this->assertDatabaseHas('obat', ['id_obat' => $obat->id_obat, 'nama_obat' => 'Obat Test Updated']);

        $this->delete(route('obat.destroy', $obat))->assertRedirect(route('obat.index'));

        $this->assertDatabaseMissing('obat', ['id_obat' => $obat->id_obat]);
    }

    public function test_price_and_stock_reject_letters(): void
    {
        $this->from(route('obat.create'))
            ->post(route('obat.store'), [
                'kode_obat' => 'OBT-INVALID',
                'nama_obat' => 'Obat Invalid',
                'satuan_obat' => 'Tablet',
                'harga_obat' => '12abc',
                'stok_obat' => '10xyz',
            ])
            ->assertRedirect(route('obat.create'))
            ->assertSessionHasErrors(['harga_obat', 'stok_obat']);

        $this->assertDatabaseMissing('obat', ['kode_obat' => 'OBT-INVALID']);
    }
}
