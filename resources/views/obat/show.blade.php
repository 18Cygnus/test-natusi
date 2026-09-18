@extends('layouts.app')
@section('title', $obat->nama_obat)
@section('heading', 'Detail Obat')
@section('content')
    <div class="max-w-3xl rounded-xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
        <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-start">
            <div>
                <p class="font-mono text-sm text-cyan-700">{{ $obat->kode_obat }}</p>
                <h3 class="mt-2 text-2xl font-semibold">{{ $obat->nama_obat }}</h3>
            </div><span class="rounded-full bg-emerald-100 px-3 py-1 text-sm font-semibold text-emerald-700">Stok
                {{ $obat->stok_obat }}</span>
        </div>
        <dl class="mt-8 grid gap-5 border-t border-slate-100 pt-6 sm:grid-cols-3">
            <div>
                <dt class="text-sm text-slate-500">Satuan</dt>
                <dd class="mt-1 font-semibold">{{ $obat->satuan_obat }}</dd>
            </div>
            <div>
                <dt class="text-sm text-slate-500">Harga Satuan</dt>
                <dd class="mt-1 font-semibold">Rp {{ number_format($obat->harga_obat, 0, ',', '.') }}</dd>
            </div>
            <div>
                <dt class="text-sm text-slate-500">Dibuat</dt>
                <dd class="mt-1 font-semibold">{{ $obat->created_at?->format('d-m-Y') }}</dd>
            </div>
        </dl>
        <div class="mt-8 flex gap-3"><a href="{{ route('obat.edit', $obat) }}"
                class="rounded-lg bg-cyan-500 px-4 py-2.5 text-sm font-semibold text-slate-950">Edit Obat</a><a
                href="{{ route('obat.index') }}"
                class="rounded-lg border border-slate-300 px-4 py-2.5 text-sm font-semibold text-slate-700">Kembali</a>
        </div>
    </div>
@endsection
