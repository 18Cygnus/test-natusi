@extends('layouts.app')
@section('title', 'Distributor')
@section('heading', 'Distributor')
@section('content')
    <div class="mb-6 flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
        <div>
            <p class="text-sm text-slate-500">Mitra pemasok obat</p>
            <h3 class="mt-1 text-2xl font-semibold">Daftar distributor</h3>
        </div>
        <div class="flex gap-3"><a href="{{ route('distributor.map') }}"
                class="rounded-lg border border-cyan-300 px-4 py-2.5 text-sm font-semibold text-cyan-700">Lihat Peta</a><a
                href="{{ route('distributor.create') }}"
                class="rounded-lg bg-cyan-500 px-4 py-2.5 text-sm font-semibold text-slate-950">+ Distributor</a></div>
    </div>
    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[750px] text-left text-sm">
                <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500">
                    <tr>
                        <th class="px-5 py-4">No</th>
                        <th class="px-5 py-4">Nama</th>
                        <th class="px-5 py-4">Kota</th>
                        <th class="px-5 py-4">Telepon</th>
                        <th class="px-5 py-4">Lokasi</th>
                        <th class="px-5 py-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($distributors as $index => $distributor)
                        <tr>
                            <td class="px-5 py-4">{{ $distributors->firstItem() + $index }}</td>
                            <td class="px-5 py-4 font-medium">{{ $distributor->nama_distributor }}</td>
                            <td class="px-5 py-4">{{ $distributor->kota ?: '-' }}</td>
                            <td class="px-5 py-4">{{ $distributor->telepon ?: '-' }}</td>
                            <td class="px-5 py-4">{{ $distributor->latitude !== null ? 'Tersedia' : 'Belum diatur' }}</td>
                            <td class="px-5 py-4">
                                <div class="flex gap-3"><a href="{{ route('distributor.show', $distributor) }}"
                                        class="font-semibold text-cyan-700">Lihat</a><a
                                        href="{{ route('distributor.edit', $distributor) }}"
                                        class="font-semibold text-slate-600">Edit</a>
                                    <form method="POST" action="{{ route('distributor.destroy', $distributor) }}"
                                        onsubmit="return confirm('Hapus distributor ini?')">@csrf @method('DELETE')<button
                                            class="font-semibold text-rose-600">Hapus</button></form>
                                </div>
                            </td>
                    </tr>@empty<tr>
                            <td colspan="6" class="px-5 py-12 text-center text-slate-500">Belum ada distributor.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($distributors->hasPages())
            <div class="border-t border-slate-100 px-5 py-4">{{ $distributors->links() }}</div>
        @endif
    </div>
@endsection
