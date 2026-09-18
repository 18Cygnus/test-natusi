@extends('layouts.app')
@section('title', 'Laporan Penjualan')
@section('heading', 'Laporan Penjualan')
@section('content')
    <div class="mb-6 flex flex-col justify-between gap-4 sm:flex-row sm:items-end no-print">
        <div>
            <p class="text-sm text-slate-500">Ringkasan periode {{ \Carbon\Carbon::parse($from)->format('d-m-Y') }} sampai
                {{ \Carbon\Carbon::parse($to)->format('d-m-Y') }}</p>
            <h3 class="mt-1 text-2xl font-semibold">Total penjualan</h3>
        </div><button onclick="window.print()"
            class="rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">Cetak
            Laporan</button>
    </div>
    <form method="GET"
        class="mb-6 grid gap-4 rounded-xl border border-slate-200 bg-white p-5 shadow-sm sm:grid-cols-[1fr_1fr_auto] sm:items-end no-print">
        <div><label for="from" class="mb-2 block text-sm font-medium">Dari tanggal</label><input id="from"
                name="from" type="date" value="{{ $from }}" required
                class="w-full rounded-lg border border-slate-300 px-3 py-2.5"></div>
        <div><label for="to" class="mb-2 block text-sm font-medium">Sampai tanggal</label><input id="to"
                name="to" type="date" value="{{ $to }}" required
                class="w-full rounded-lg border border-slate-300 px-3 py-2.5"></div><button
            class="rounded-lg bg-cyan-500 px-4 py-2.5 text-sm font-semibold text-slate-950">Terapkan</button>
    </form>
    <div class="mb-6 grid gap-4 sm:grid-cols-3">
        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-sm text-slate-500">Jumlah transaksi</p>
            <p class="mt-2 text-2xl font-semibold">{{ $transaksi->count() }}</p>
        </div>
        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-sm text-slate-500">Total qty terjual</p>
            <p class="mt-2 text-2xl font-semibold">{{ $totalQty }}</p>
        </div>
        <div class="rounded-xl border border-cyan-200 bg-cyan-50 p-5 shadow-sm">
            <p class="text-sm text-cyan-700">Grand total</p>
            <p class="mt-2 text-2xl font-semibold text-cyan-950">Rp {{ number_format($grandTotal, 0, ',', '.') }}</p>
        </div>
    </div>
    <div class="mb-6 overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-100 px-5 py-4">
            <h4 class="font-semibold">Per transaksi</h4>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full min-w-[650px] text-left text-sm">
                <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500">
                    <tr>
                        <th class="px-5 py-4">No</th>
                        <th class="px-5 py-4">Tanggal</th>
                        <th class="px-5 py-4">No Faktur</th>
                        <th class="px-5 py-4">Pembeli</th>
                        <th class="px-5 py-4">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($transaksi as $index => $item)
                        <tr>
                            <td class="px-5 py-4">{{ $index + 1 }}</td>
                            <td class="px-5 py-4">{{ $item->tanggal->format('d-m-Y') }}</td>
                            <td class="px-5 py-4 font-mono text-xs text-cyan-700">{{ $item->no_faktur }}</td>
                            <td class="px-5 py-4">{{ $item->nama_pembeli ?: '-' }}</td>
                            <td class="px-5 py-4 font-semibold">Rp {{ number_format($item->total, 0, ',', '.') }}</td>
                    </tr>@empty<tr>
                            <td colspan="5" class="px-5 py-12 text-center text-slate-500">Tidak ada transaksi pada
                                periode ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-100 px-5 py-4">
            <h4 class="font-semibold">Per obat</h4>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full min-w-[650px] text-left text-sm">
                <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500">
                    <tr>
                        <th class="px-5 py-4">No</th>
                        <th class="px-5 py-4">Kode</th>
                        <th class="px-5 py-4">Nama Obat</th>
                        <th class="px-5 py-4">Terjual</th>
                        <th class="px-5 py-4">Pendapatan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($perObat as $index => $item)
                        <tr>
                            <td class="px-5 py-4">{{ $index + 1 }}</td>
                            <td class="px-5 py-4 font-mono text-xs text-cyan-700">{{ $item->obat->kode_obat }}</td>
                            <td class="px-5 py-4 font-medium">{{ $item->obat->nama_obat }}</td>
                            <td class="px-5 py-4">{{ $item->total_qty }}</td>
                            <td class="px-5 py-4 font-semibold">Rp
                                {{ number_format($item->total_pendapatan, 0, ',', '.') }}</td>
                    </tr>@empty<tr>
                            <td colspan="5" class="px-5 py-12 text-center text-slate-500">Tidak ada detail penjualan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
@push('styles')
    <style>
        @media print {

            .no-print,
            aside,
            header {
                display: none !important;
            }

            main {
                width: 100%;
            }

            body {
                background: white;
            }
        }
    </style>
@endpush
