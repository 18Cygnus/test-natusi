<?php

namespace Tests\Feature;

use App\Models\Obat;
use App\Models\Transaksi;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class LaporanFeatureTest extends TestCase
{
    use DatabaseTransactions;

    public function test_stock_report_calculates_asset_value_and_sales_report_filters_and_aggregates(): void
    {
        $obat = Obat::factory()->create(['nama_obat' => 'Laporan Obat', 'harga_obat' => 2500, 'stok_obat' => 4]);
        $outsideObat = Obat::factory()->create(['harga_obat' => 1000, 'stok_obat' => 10]);
        $transaction = Transaksi::factory()->create(['tanggal' => '2026-09-10', 'total' => 5000]);
        $transaction->details()->create(['obat_id' => $obat->id_obat, 'qty' => 2, 'harga_satuan' => 2500, 'subtotal' => 5000]);
        $outside = Transaksi::factory()->create(['tanggal' => '2026-08-10', 'total' => 9000]);
        $outside->details()->create(['obat_id' => $outsideObat->id_obat, 'qty' => 9, 'harga_satuan' => 1000, 'subtotal' => 9000]);
        $expectedAssetValue = Obat::query()->get()->sum(fn (Obat $item): float => $item->harga_obat * $item->stok_obat);

        $this->get(route('laporan.stok'))->assertOk()->assertSee('Laporan Obat')->assertSee('Rp '.number_format($expectedAssetValue, 0, ',', '.'));
        $this->get(route('laporan.penjualan', ['from' => '2026-09-01', 'to' => '2026-09-30']))
            ->assertOk()
            ->assertSee($transaction->no_faktur)
            ->assertSee('Rp 5.000')
            ->assertDontSee($outside->no_faktur);
    }
}
