@extends('layouts.app')
@section('title', 'Transaksi Baru')
@section('heading', 'Transaksi Baru')
@section('content')
    <form method="POST" action="{{ route('transaksi.store') }}" id="transaction-form" class="space-y-6">@csrf
        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="mb-6">
                <p class="text-sm text-slate-500">Penjualan</p>
                <h3 class="mt-1 text-xl font-semibold">Informasi transaksi</h3>
            </div>
            <div class="grid gap-5 sm:grid-cols-2">
                <div><label class="mb-2 block text-sm font-medium text-slate-700" for="tanggal">Tanggal</label><input
                        class="w-full rounded-lg border border-slate-300 px-3 py-2.5" type="date" name="tanggal"
                        id="tanggal" value="{{ old('tanggal', now()->toDateString()) }}" required></div>
                <div><label class="mb-2 block text-sm font-medium text-slate-700" for="nama_pembeli">Nama Pembeli <span
                            class="font-normal text-slate-400">(opsional)</span></label><input
                        class="w-full rounded-lg border border-slate-300 px-3 py-2.5" name="nama_pembeli" id="nama_pembeli"
                        value="{{ old('nama_pembeli') }}" maxlength="150"></div>
            </div>
        </div>
        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="mb-5 flex items-center justify-between gap-4">
                <div>
                    <h3 class="text-xl font-semibold">Daftar obat</h3>
                    <p class="mt-1 text-sm text-slate-500">Stok akan berkurang setelah transaksi disimpan.</p>
                </div><button type="button" id="add-item"
                    class="rounded-lg border border-cyan-300 px-3 py-2 text-sm font-semibold text-cyan-700 hover:bg-cyan-50">+
                    Tambah Baris</button>
            </div>
            <div id="items" class="space-y-3"></div>
            <div class="mt-6 flex items-center justify-between border-t border-slate-100 pt-5"><span
                    class="font-semibold text-slate-600">Total</span><span id="total"
                    class="text-2xl font-semibold text-slate-950">Rp 0</span></div>
            <div class="mt-6 flex gap-3"><button
                    class="rounded-lg bg-cyan-500 px-4 py-2.5 text-sm font-semibold text-slate-950 hover:bg-cyan-400">Simpan
                    Transaksi</button><a href="{{ route('transaksi.index') }}"
                    class="rounded-lg border border-slate-300 px-4 py-2.5 text-sm font-semibold text-slate-700">Batal</a>
            </div>
        </div>
    </form>
    @push('scripts')
        <script>
            const medicines = @json($obatOptions);
            const items = document.getElementById('items');
            const total = document.getElementById('total');
            const money = value => new Intl.NumberFormat('id-ID').format(value);

            function addRow() {
                const index = items.children.length;
                const row = document.createElement('div');
                row.className =
                    'grid gap-3 rounded-lg border border-slate-200 p-4 sm:grid-cols-[minmax(0,2fr)_100px_minmax(0,1fr)_minmax(0,1fr)_auto] sm:items-end';
                row.innerHTML =
                    `<div><label class="mb-2 block text-xs font-semibold uppercase tracking-wide text-slate-500">Obat</label><select name="items[${index}][obat_id]" required class="medicine w-full rounded-lg border border-slate-300 px-3 py-2.5"><option value="">Pilih obat</option>${medicines.map(m => `<option value="${m.id}">${m.code} - ${m.name} (${m.stock})</option>`).join('')}</select></div><div><label class="mb-2 block text-xs font-semibold uppercase tracking-wide text-slate-500">Qty</label><input name="items[${index}][qty]" type="number" inputmode="numeric" min="1" step="1" value="1" required oninput="this.value = this.value.replace(/[^0-9]/g, '')" class="qty w-full rounded-lg border border-slate-300 px-3 py-2.5"></div><div><label class="mb-2 block text-xs font-semibold uppercase tracking-wide text-slate-500">Harga</label><p class="price rounded-lg bg-slate-50 px-3 py-2.5 text-sm">Rp 0</p></div><div><label class="mb-2 block text-xs font-semibold uppercase tracking-wide text-slate-500">Subtotal</label><p class="subtotal rounded-lg bg-slate-50 px-3 py-2.5 text-sm font-semibold">Rp 0</p></div><button type="button" class="remove rounded-lg px-2 py-2.5 text-sm font-semibold text-rose-600 hover:bg-rose-50">Hapus</button>`;
                items.append(row);
                row.querySelector('.medicine').addEventListener('change', () => updateRow(row));
                row.querySelector('.qty').addEventListener('input', () => updateRow(row));
                row.querySelector('.remove').addEventListener('click', () => {
                    row.remove();
                    updateTotal();
                });
            }

            function updateRow(row) {
                const medicine = medicines.find(m => String(m.id) === row.querySelector('.medicine').value);
                const qty = Number(row.querySelector('.qty').value || 0);
                const price = medicine?.price || 0;
                row.querySelector('.price').textContent = `Rp ${money(price)}`;
                row.querySelector('.subtotal').textContent = `Rp ${money(price * qty)}`;
                updateTotal();
            }

            function updateTotal() {
                total.textContent =
                    `Rp ${money([...document.querySelectorAll('.subtotal')].reduce((sum, el) => sum + Number(el.textContent.replace(/[^0-9]/g, '') || 0), 0))}`;
            }
            document.getElementById('add-item').addEventListener('click', addRow);
            addRow();
        </script>
    @endpush
@endsection
