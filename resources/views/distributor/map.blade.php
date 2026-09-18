@extends('layouts.app')
@section('title', 'Peta Distributor')
@section('heading', 'Peta Distributor')
@section('content')<div class="mb-6 flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
        <div>
            <p class="text-sm text-slate-500">{{ $distributors->count() }} distributor dengan koordinat</p>
            <h3 class="mt-1 text-2xl font-semibold">Lokasi mitra pemasok</h3>
        </div><a href="{{ route('distributor.index') }}"
            class="rounded-lg border border-slate-300 px-4 py-2.5 text-sm font-semibold text-slate-700">Kembali ke Daftar</a>
    </div>
    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white p-3 shadow-sm">
        <div id="all-distributor-map" class="h-[min(70vh,680px)] min-h-[520px] rounded-lg"></div>
    </div>
    @push('styles')
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
    @endpush
    @push('scripts')
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const distributors = @json($distributors);
                const escapeHtml = value => String(value ?? '-').replace(/[&<>'"]/g, character => ({
                    '&': '&amp;',
                    '<': '&lt;',
                    '>': '&gt;',
                    "'": '&#039;',
                    '"': '&quot;'
                })[character]);
                const map = L.map('all-distributor-map').setView([-2.5489, 118.0149], 5);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; OpenStreetMap contributors',
                    maxZoom: 19
                }).addTo(map);
                const bounds = [];
                distributors.forEach(distributor => {
                    const point = [Number(distributor.latitude), Number(distributor.longitude)];
                    if (!point.every(Number.isFinite)) return;
                    const marker = L.marker(point).addTo(map);
                    marker.bindPopup(
                        `<strong>${escapeHtml(distributor.nama_distributor)}</strong><br>${escapeHtml(distributor.alamat)}<br>${escapeHtml(distributor.kota)}<br><a href="/distributor/${Number(distributor.id)}">Lihat Detail</a>`
                        );
                    bounds.push(point);
                });
                if (bounds.length) map.fitBounds(bounds, {
                    padding: [30, 30],
                    maxZoom: 14
                });
            });
        </script>
    @endpush
@endsection
