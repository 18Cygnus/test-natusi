@extends('layouts.app')
@section('title', $distributor->nama_distributor)
@section('heading', 'Detail Distributor')
@section('content')<div class="grid gap-6 lg:grid-cols-[minmax(0,0.8fr)_minmax(0,1.2fr)]">
        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm text-cyan-700">Distributor</p>
            <h3 class="mt-2 text-2xl font-semibold">{{ $distributor->nama_distributor }}</h3>
            <dl class="mt-8 space-y-5 border-t border-slate-100 pt-6">
                <div>
                    <dt class="text-sm text-slate-500">Alamat</dt>
                    <dd class="mt-1">
                        {{ $distributor->alamat ?: '-' }}{{ $distributor->kota ? ', ' . $distributor->kota : '' }}</dd>
                </div>
                <div>
                    <dt class="text-sm text-slate-500">Telepon</dt>
                    <dd class="mt-1">{{ $distributor->telepon ?: '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm text-slate-500">Email</dt>
                    <dd class="mt-1">{{ $distributor->email ?: '-' }}</dd>
                </div>
            </dl>
            <div class="mt-8 flex gap-3"><a href="{{ route('distributor.edit', $distributor) }}"
                    class="rounded-lg bg-cyan-500 px-4 py-2.5 text-sm font-semibold text-slate-950">Edit</a><a
                    href="{{ route('distributor.index') }}"
                    class="rounded-lg border border-slate-300 px-4 py-2.5 text-sm font-semibold text-slate-700">Kembali</a>
            </div>
        </div>
        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white p-3 shadow-sm">
            <div id="show-map" class="h-[420px] rounded-lg"></div>
        </div>
    </div>
    @push('styles')
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
    @endpush
    @push('scripts')
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const point = [{{ $distributor->latitude ?? -6.1751 }}, {{ $distributor->longitude ?? 106.865 }}];
                const map = L.map('show-map').setView(point, 14);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; OpenStreetMap contributors'
                }).addTo(map);
                L.marker(point).addTo(map).bindPopup(@json($distributor->nama_distributor)).openPopup();
            });
        </script>
    @endpush
@endsection
