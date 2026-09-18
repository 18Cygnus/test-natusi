@csrf
<div class="grid gap-5 sm:grid-cols-2">
    <div class="sm:col-span-2"><label for="nama_distributor" class="mb-2 block text-sm font-medium">Nama
            Distributor</label><input id="nama_distributor" name="nama_distributor"
            value="{{ old('nama_distributor', $distributor->nama_distributor ?? '') }}" required maxlength="150"
            class="w-full rounded-lg border border-slate-300 px-3 py-2.5"></div>
    <div class="sm:col-span-2"><label for="alamat" class="mb-2 block text-sm font-medium">Alamat</label>
        <textarea id="alamat" name="alamat" rows="2" maxlength="255"
            class="w-full rounded-lg border border-slate-300 px-3 py-2.5">{{ old('alamat', $distributor->alamat ?? '') }}</textarea>
    </div>
    <div><label for="kota" class="mb-2 block text-sm font-medium">Kota</label><input id="kota" name="kota"
            value="{{ old('kota', $distributor->kota ?? '') }}" maxlength="100"
            class="w-full rounded-lg border border-slate-300 px-3 py-2.5"></div>
    <div><label for="telepon" class="mb-2 block text-sm font-medium">Telepon</label><input id="telepon"
            name="telepon" value="{{ old('telepon', $distributor->telepon ?? '') }}" maxlength="20"
            class="w-full rounded-lg border border-slate-300 px-3 py-2.5"></div>
    <div class="sm:col-span-2"><label for="email" class="mb-2 block text-sm font-medium">Email</label><input
            id="email" name="email" type="email" value="{{ old('email', $distributor->email ?? '') }}"
            maxlength="150" class="w-full rounded-lg border border-slate-300 px-3 py-2.5"></div>
</div>
<div class="mt-6">
    <div class="mb-3 flex items-center justify-between gap-3">
        <div>
            <h4 class="font-semibold">Pilih lokasi</h4>
            <p class="text-sm text-slate-500">Klik peta atau geser marker untuk mengisi koordinat.</p>
        </div><button type="button" id="locate"
            class="rounded-lg border border-cyan-300 px-3 py-2 text-sm font-semibold text-cyan-700">Lokasi Saya</button>
    </div>
    <div id="distributor-map" class="h-[360px] rounded-xl border border-slate-200"></div>
</div>
<div class="mt-5 grid gap-5 sm:grid-cols-2">
    <div><label for="latitude" class="mb-2 block text-sm font-medium">Latitude</label><input id="latitude"
            name="latitude" type="number" step="any"
            value="{{ old('latitude', $distributor->latitude ?? -6.1751) }}"
            class="w-full rounded-lg border border-slate-300 px-3 py-2.5"></div>
    <div><label for="longitude" class="mb-2 block text-sm font-medium">Longitude</label><input id="longitude"
            name="longitude" type="number" step="any"
            value="{{ old('longitude', $distributor->longitude ?? 106.865) }}"
            class="w-full rounded-lg border border-slate-300 px-3 py-2.5"></div>
</div>
<div class="mt-6 flex gap-3"><button
        class="rounded-lg bg-cyan-500 px-4 py-2.5 text-sm font-semibold text-slate-950">{{ $submitLabel }}</button><a
        href="{{ route('distributor.index') }}"
        class="rounded-lg border border-slate-300 px-4 py-2.5 text-sm font-semibold text-slate-700">Batal</a></div>
@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
@endpush
@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const latInput = document.getElementById('latitude');
            const lngInput = document.getElementById('longitude');
            const initial = [Number(latInput.value) || -6.1751, Number(lngInput.value) || 106.865];
            const map = L.map('distributor-map').setView(initial, 13);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors',
                maxZoom: 19
            }).addTo(map);
            const marker = L.marker(initial, {
                draggable: true
            }).addTo(map);
            const sync = point => {
                latInput.value = point.lat.toFixed(6);
                lngInput.value = point.lng.toFixed(6);
            };
            marker.on('dragend', event => sync(event.target.getLatLng()));
            map.on('click', event => {
                marker.setLatLng(event.latlng);
                sync(event.latlng);
            });
            latInput.addEventListener('change', () => {
                const point = [Number(latInput.value), Number(lngInput.value)];
                if (point.every(Number.isFinite)) {
                    marker.setLatLng(point);
                    map.panTo(point);
                }
            });
            lngInput.addEventListener('change', () => latInput.dispatchEvent(new Event('change')));
            document.getElementById('locate').addEventListener('click', () => navigator.geolocation
                ?.getCurrentPosition(position => {
                    const point = [position.coords.latitude, position.coords.longitude];
                    marker.setLatLng(point);
                    map.setView(point, 15);
                    sync({
                        lat: point[0],
                        lng: point[1]
                    });
                }));
        });
    </script>
@endpush
