<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LaporanController extends Controller
{
    public function stok(): View
    {
        $obat = Obat::query()->orderBy('stok_obat')->orderBy('nama_obat')->get();
        $totalAset = $obat->sum(fn (Obat $item): float => $item->harga_obat * $item->stok_obat);

        return view('laporan.stok', compact('obat', 'totalAset'));
    }

    public function penjualan(Request $request): View
    {
        $from = $request->query('from', now()->startOfMonth()->toDateString());
        $to = $request->query('to', now()->toDateString());

        $transaksi = Transaksi::query()
            ->whereBetween('tanggal', [$from, $to])
            ->orderBy('tanggal')
            ->orderBy('id')
            ->get();
        $perObat = TransaksiDetail::query()
            ->whereHas('transaksi', fn ($query) => $query->whereBetween('tanggal', [$from, $to]))
            ->selectRaw('obat_id, SUM(qty) as total_qty, SUM(subtotal) as total_pendapatan')
            ->groupBy('obat_id')
            ->with('obat')
            ->get();
        $grandTotal = $transaksi->sum('total');
        $totalQty = $perObat->sum('total_qty');

        return view('laporan.penjualan', compact('transaksi', 'perObat', 'grandTotal', 'totalQty', 'from', 'to'));
    }
}
