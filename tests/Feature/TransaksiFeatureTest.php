<?php

namespace Tests\Feature;

use App\Models\Obat;
use App\Models\Transaksi;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class TransaksiFeatureTest extends TestCase
{
    use DatabaseTransactions;

    public function test_user_can_create_transaction_and_stock_is_decremented(): void
    {
        $firstObat = Obat::factory()->create(['harga_obat' => 2500, 'stok_obat' => 10]);
        $secondObat = Obat::factory()->create(['harga_obat' => 4000, 'stok_obat' => 8]);

        $response = $this->post(route('transaksi.store'), [
            'tanggal' => '2026-09-18',
            'nama_pembeli' => 'Pembeli Test',
            'items' => [
                ['obat_id' => $firstObat->id_obat, 'qty' => 2],
                ['obat_id' => $secondObat->id_obat, 'qty' => 1],
            ],
        ]);

        $transaksi = Transaksi::query()->with('details')->latest('id')->firstOrFail();

        $response->assertRedirect(route('transaksi.cetak', $transaksi));
        $this->assertSame(9000.0, (float) $transaksi->total);
        $this->assertCount(2, $transaksi->details);
        $this->assertDatabaseHas('obat', ['id_obat' => $firstObat->id_obat, 'stok_obat' => 8]);
        $this->assertDatabaseHas('obat', ['id_obat' => $secondObat->id_obat, 'stok_obat' => 7]);
        $this->get(route('transaksi.show', $transaksi))->assertOk()->assertSee('Pembeli Test');
        $this->get(route('transaksi.cetak', $transaksi))->assertOk()->assertSee('Struk Penjualan');
    }

    public function test_transaction_quantity_rejects_letters(): void
    {
        $obat = Obat::factory()->create(['stok_obat' => 10]);

        $this->from(route('transaksi.create'))
            ->post(route('transaksi.store'), [
                'tanggal' => '2026-09-18',
                'items' => [
                    ['obat_id' => $obat->id_obat, 'qty' => '2abc'],
                ],
            ])
            ->assertRedirect(route('transaksi.create'))
            ->assertSessionHasErrors('items.0.qty');

        $this->assertDatabaseMissing('transaksi_detail', ['obat_id' => $obat->id_obat]);
        $this->assertDatabaseHas('obat', ['id_obat' => $obat->id_obat, 'stok_obat' => 10]);
    }
}
