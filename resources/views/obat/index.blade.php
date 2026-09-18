@extends('layouts.app')
@section('title', 'Master Obat')
@section('heading', 'Master Obat')
@section('content')
    <div class="mb-6 flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
        <div>
            <p class="text-sm text-slate-500">{{ $obats->total() }} produk terdaftar</p>
            <h3 class="mt-1 text-2xl font-semibold">Daftar inventori</h3>
        </div>
        <a href="{{ route('obat.create') }}"
            class="rounded-lg bg-cyan-500 px-4 py-2.5 text-center text-sm font-semibold text-slate-950 hover:bg-cyan-400">+
            Tambah Obat</a>
    </div>
    <form method="GET" class="mb-5 flex max-w-xl gap-3">
        <input name="q" value="{{ request('q') }}" placeholder="Cari kode atau nama obat"
            class="min-w-0 flex-1 rounded-lg border border-slate-300 bg-white px-3 py-2.5 outline-none ring-cyan-300 focus:ring-2">
        <button
            class="rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold hover:bg-slate-50">Cari</button>
    </form>
    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[720px] text-left text-sm">
                <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500">
                    <tr>
                        <th class="px-5 py-4">No</th>
                        <th class="px-5 py-4">Kode</th>
                        <th class="px-5 py-4">Nama</th>
                        <th class="px-5 py-4">Satuan</th>
                        <th class="px-5 py-4">Harga</th>
                        <th class="px-5 py-4">Stok</th>
                        <th class="px-5 py-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($obats as $index => $obat)
                        <tr class="hover:bg-slate-50">
                            <td class="px-5 py-4 text-slate-500">{{ $obats->firstItem() + $index }}</td>
                            <td class="px-5 py-4 font-mono text-xs text-cyan-700">{{ $obat->kode_obat }}</td>
                            <td class="px-5 py-4 font-medium">{{ $obat->nama_obat }}</td>
                            <td class="px-5 py-4 text-slate-600">{{ $obat->satuan_obat }}</td>
                            <td class="px-5 py-4">Rp {{ number_format($obat->harga_obat, 0, ',', '.') }}</td>
                            <td class="px-5 py-4"><span
                                    class="rounded-full px-2.5 py-1 text-xs font-semibold {{ $obat->stok_obat < 10 ? 'bg-rose-100 text-rose-700' : 'bg-emerald-100 text-emerald-700' }}">{{ $obat->stok_obat }}</span>
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex gap-3"><a class="font-semibold text-cyan-700 hover:underline"
                                        href="{{ route('obat.show', $obat) }}">Lihat</a><a
                                        class="font-semibold text-slate-600 hover:underline"
                                        href="{{ route('obat.edit', $obat) }}">Edit</a>
                                    <form method="POST" action="{{ route('obat.destroy', $obat) }}"
                                        onsubmit="return confirm('Hapus obat ini?')">@csrf @method('DELETE')<button
                                            class="font-semibold text-rose-600 hover:underline">Hapus</button></form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-12 text-center text-slate-500">Belum ada obat yang cocok.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($obats->hasPages())
            <div class="border-t border-slate-100 px-5 py-4">{{ $obats->links() }}</div>
        @endif
    </div>
@endsection
