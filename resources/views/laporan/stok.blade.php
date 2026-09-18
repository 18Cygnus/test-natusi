@extends('layouts.app')
@section('title', 'Laporan Stok')
@section('heading', 'Laporan Stok')
@section('content')
    <div class="mb-6 flex flex-col justify-between gap-4 sm:flex-row sm:items-end no-print">
        <div>
            <p class="text-sm text-slate-500">Inventori terkini</p>
            <h3 class="mt-1 text-2xl font-semibold">Sisa stok per obat</h3>
        </div><button onclick="window.print()"
            class="rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">Cetak
            Laporan</button>
    </div>
    <div class="mb-6 grid gap-4 sm:grid-cols-2">
        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-sm text-slate-500">Total jenis obat</p>
            <p class="mt-2 text-2xl font-semibold">{{ $obat->count() }}</p>
        </div>
        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-sm text-slate-500">Nilai aset stok</p>
            <p class="mt-2 text-2xl font-semibold">Rp {{ number_format($totalAset, 0, ',', '.') }}</p>
        </div>
    </div>
    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[700px] text-left text-sm">
                <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500">
                    <tr>
                        <th class="px-5 py-4">No</th>
                        <th class="px-5 py-4">Kode</th>
                        <th class="px-5 py-4">Nama Obat</th>
                        <th class="px-5 py-4">Satuan</th>
                        <th class="px-5 py-4">Harga</th>
                        <th class="px-5 py-4">Stok Tersisa</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($obat as $index => $item)
                        <tr class="{{ $item->stok_obat < 10 ? 'bg-rose-50' : '' }}">
                            <td class="px-5 py-4 text-slate-500">{{ $index + 1 }}</td>
                            <td class="px-5 py-4 font-mono text-xs text-cyan-700">{{ $item->kode_obat }}</td>
                            <td class="px-5 py-4 font-medium">{{ $item->nama_obat }}</td>
                            <td class="px-5 py-4">{{ $item->satuan_obat }}</td>
                            <td class="px-5 py-4">Rp {{ number_format($item->harga_obat, 0, ',', '.') }}</td>
                            <td class="px-5 py-4"><span
                                    class="rounded-full px-2.5 py-1 text-xs font-semibold {{ $item->stok_obat < 10 ? 'bg-rose-200 text-rose-800' : 'bg-emerald-100 text-emerald-700' }}">{{ $item->stok_obat }}{{ $item->stok_obat < 10 ? ' · Menipis' : '' }}</span>
                            </td>
                    </tr>@empty<tr>
                            <td colspan="6" class="px-5 py-12 text-center text-slate-500">Belum ada data obat.</td>
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
