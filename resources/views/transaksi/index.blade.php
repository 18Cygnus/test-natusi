@extends('layouts.app')
@section('title', 'Transaksi Penjualan')
@section('heading', 'Transaksi Penjualan')
@section('content')
    <div class="mb-6 flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
        <div>
            <p class="text-sm text-slate-500">Riwayat penjualan</p>
            <h3 class="mt-1 text-2xl font-semibold">Daftar transaksi</h3>
        </div><a href="{{ route('transaksi.create') }}"
            class="rounded-lg bg-cyan-500 px-4 py-2.5 text-center text-sm font-semibold text-slate-950 hover:bg-cyan-400">+
            Transaksi Baru</a>
    </div>
    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[700px] text-left text-sm">
                <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500">
                    <tr>
                        <th class="px-5 py-4">No Faktur</th>
                        <th class="px-5 py-4">Tanggal</th>
                        <th class="px-5 py-4">Pembeli</th>
                        <th class="px-5 py-4">Total</th>
                        <th class="px-5 py-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($transaksis as $transaksi)
                        <tr class="hover:bg-slate-50">
                            <td class="px-5 py-4 font-mono text-xs text-cyan-700">{{ $transaksi->no_faktur }}</td>
                            <td class="px-5 py-4">{{ $transaksi->tanggal->format('d-m-Y') }}</td>
                            <td class="px-5 py-4">{{ $transaksi->nama_pembeli ?: '-' }}</td>
                            <td class="px-5 py-4 font-semibold">Rp {{ number_format($transaksi->total, 0, ',', '.') }}</td>
                            <td class="px-5 py-4">
                                <div class="flex gap-3"><a class="font-semibold text-cyan-700 hover:underline"
                                        href="{{ route('transaksi.show', $transaksi) }}">Lihat</a><a
                                        class="font-semibold text-slate-600 hover:underline"
                                        href="{{ route('transaksi.cetak', $transaksi) }}">Cetak</a></div>
                            </td>
                    </tr>@empty<tr>
                            <td colspan="5" class="px-5 py-12 text-center text-slate-500">Belum ada transaksi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($transaksis->hasPages())
            <div class="border-t border-slate-100 px-5 py-4">{{ $transaksis->links() }}</div>
        @endif
    </div>
@endsection
