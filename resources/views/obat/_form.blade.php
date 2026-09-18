@csrf
<div class="grid gap-5 sm:grid-cols-2">
    <div>
        <label for="kode_obat" class="mb-2 block text-sm font-medium text-slate-700">Kode Obat</label>
        <input id="kode_obat" name="kode_obat" value="{{ old('kode_obat', $obat->kode_obat ?? '') }}" required
            maxlength="45"
            class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 outline-none ring-cyan-300 focus:ring-2">
    </div>
    <div>
        <label for="nama_obat" class="mb-2 block text-sm font-medium text-slate-700">Nama Obat</label>
        <input id="nama_obat" name="nama_obat" value="{{ old('nama_obat', $obat->nama_obat ?? '') }}" required
            maxlength="255"
            class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 outline-none ring-cyan-300 focus:ring-2">
    </div>
    <div>
        <label for="satuan_obat" class="mb-2 block text-sm font-medium text-slate-700">Satuan</label>
        <input id="satuan_obat" name="satuan_obat" value="{{ old('satuan_obat', $obat->satuan_obat ?? '') }}" required
            maxlength="45" placeholder="Tablet, kapsul, botol"
            class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 outline-none ring-cyan-300 focus:ring-2">
    </div>
    <div>
        <label for="harga_obat" class="mb-2 block text-sm font-medium text-slate-700">Harga Satuan</label>
        <input id="harga_obat" name="harga_obat" type="number" inputmode="decimal" min="0" step="0.01"
            value="{{ old('harga_obat', $obat->harga_obat ?? '') }}" required
            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')"
            class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 outline-none ring-cyan-300 focus:ring-2">
    </div>
    <div>
        <label for="stok_obat" class="mb-2 block text-sm font-medium text-slate-700">Stok</label>
        <input id="stok_obat" name="stok_obat" type="number" inputmode="numeric" min="0" step="1"
            value="{{ old('stok_obat', $obat->stok_obat ?? 0) }}" required
            oninput="this.value = this.value.replace(/[^0-9]/g, '')"
            class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 outline-none ring-cyan-300 focus:ring-2">
    </div>
</div>
<div class="mt-6 flex gap-3">
    <button
        class="rounded-lg bg-cyan-500 px-4 py-2.5 text-sm font-semibold text-slate-950 hover:bg-cyan-400">{{ $submitLabel }}</button>
    <a href="{{ route('obat.index') }}"
        class="rounded-lg border border-slate-300 px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">Batal</a>
</div>
