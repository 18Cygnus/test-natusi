@extends('layouts.app')
@section('title', 'Detail ' . $transaksi->no_faktur)
@section('heading', 'Detail Transaksi')
@section('content')
    <div class="mb-6 flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
        <div>
            <p class="font-mono text-sm text-cyan-700">{{ $transaksi->no_faktur }}</p>
            <h3 class="mt-1 text-2xl font-semibold">Detail transaksi</h3>
        </div>
        <div class="flex gap-3"><a href="{{ route('transaksi.cetak', $transaksi) }}"
                class="rounded-lg bg-cyan-500 px-4 py-2.5 text-sm font-semibold text-slate-950">Cetak Struk</a><a
                href="{{ route('transaksi.index') }}"
                class="rounded-lg border border-slate-300 px-4 py-2.5 text-sm font-semibold text-slate-700">Kembali</a></div>
    </div>
    <div class="mb-6 grid gap-4 sm:grid-cols-3">
        <div class="rounded-xl border border-slate-200 bg-white p-5">
            <p class="text-sm text-slate-500">Tanggal</p>
            <p class="mt-2 font-semibold">{{ $transaksi->tanggal->format('d-m-Y') }}</p>
        </div>
        <div class="rounded-xl border border-slate-200 bg-white p-5">
            <p class="text-sm text-slate-500">Nama Pembeli</p>
            <p class="mt-2 font-semibold">{{ $transaksi->nama_pembeli ?: '-' }}</p>
        </div>
        <div class="rounded-xl border border-slate-200 bg-white p-5">
            <p class="text-sm text-slate-500">Total</p>
            <p class="mt-2 font-semibold">Rp {{ number_format($transaksi->total, 0, ',', '.') }}</p>
        </div>
    </div>
    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[760px] text-left text-sm">
                <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500">
                    <tr>
                        <th class="px-5 py-4">No</th>
                        <th class="px-5 py-4">Kode</th>
                        <th class="px-5 py-4">Nama Obat</th>
                        <th class="px-5 py-4">Satuan</th>
                        <th class="px-5 py-4">Harga</th>
                        <th class="px-5 py-4">Qty</th>
                        <th class="px-5 py-4">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($transaksi->details as $index => $detail)
                        <tr>
                            <td class="px-5 py-4 text-slate-500">{{ $index + 1 }}</td>
                            <td class="px-5 py-4 font-mono text-xs text-cyan-700">{{ $detail->obat->kode_obat }}</td>
                            <td class="px-5 py-4 font-medium">{{ $detail->obat->nama_obat }}</td>
                            <td class="px-5 py-4">{{ $detail->obat->satuan_obat }}</td>
                            <td class="px-5 py-4">Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                            <td class="px-5 py-4">{{ $detail->qty }}</td>
                            <td class="px-5 py-4 font-semibold">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="border-t border-slate-200 bg-slate-50">
                    <tr>
                        <th colspan="6" class="px-5 py-4 text-right">Total</th>
                        <th class="px-5 py-4">Rp {{ number_format($transaksi->total, 0, ',', '.') }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection
