<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransaksiRequest;
use App\Models\Obat;
use App\Models\Transaksi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class TransaksiController extends Controller
{
    public function index(): View
    {
        $transaksis = Transaksi::query()->latest('tanggal')->latest('id')->paginate(10);

        return view('transaksi.index', compact('transaksis'));
    }

    public function create(): View
    {
        $obats = Obat::query()->where('stok_obat', '>', 0)->orderBy('nama_obat')->get();
        $obatOptions = $obats->map(fn (Obat $obat): array => [
            'id' => $obat->id_obat,
            'name' => $obat->nama_obat,
            'code' => $obat->kode_obat,
            'price' => $obat->harga_obat,
            'stock' => $obat->stok_obat,
        ])->values();

        return view('transaksi.create', compact('obatOptions'));
    }

    public function store(TransaksiRequest $request): RedirectResponse
    {
        $transaksi = DB::transaction(function () use ($request): Transaksi {
            $items = collect($request->validated('items'));
            $obatIds = $items->pluck('obat_id');
            $obats = Obat::query()->whereIn('id_obat', $obatIds)->lockForUpdate()->get()->keyBy('id_obat');
            $total = 0;

            $transaksi = Transaksi::create([
                'no_faktur' => $this->generateNoFaktur($request->date('tanggal')->toDateString()),
                'tanggal' => $request->date('tanggal'),
                'nama_pembeli' => $request->validated('nama_pembeli'),
                'total' => 0,
            ]);

            foreach ($items as $item) {
                $obat = $obats->get($item['obat_id']);

                abort_if($obat === null || $obat->stok_obat < $item['qty'], 422, 'Stok obat tidak cukup.');

                $subtotal = $item['qty'] * $obat->harga_obat;
                $total += $subtotal;

                $transaksi->details()->create([
                    'obat_id' => $obat->id_obat,
                    'qty' => $item['qty'],
                    'harga_satuan' => $obat->harga_obat,
                    'subtotal' => $subtotal,
                ]);

                $obat->decrement('stok_obat', $item['qty']);
            }

            $transaksi->update(['total' => $total]);

            return $transaksi;
        });

        return redirect()->route('transaksi.cetak', $transaksi)->with('success', 'Transaksi berhasil disimpan.');
    }

    public function show(Transaksi $transaksi): View
    {
        $transaksi->load('details.obat');

        return view('transaksi.show', compact('transaksi'));
    }

    public function cetak(Transaksi $transaksi): View
    {
        $transaksi->load('details.obat');

        return view('transaksi.cetak', compact('transaksi'));
    }

    private function generateNoFaktur(string $tanggal): string
    {
        $count = Transaksi::query()->whereDate('tanggal', $tanggal)->lockForUpdate()->count() + 1;

        return 'INV-'.str_replace('-', '', $tanggal).'-'.str_pad((string) $count, 4, '0', STR_PAD_LEFT);
    }
}
