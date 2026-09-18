<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk {{ $transaksi->no_faktur }}</title>@vite(['resources/css/app.css', 'resources/js/app.js'])<style>
        @media print {
            .no-print {
                display: none !important;
            }

            body {
                margin: 0;
                background: white;
            }
        }
    </style>
</head>

<body class="bg-slate-100 p-5 text-slate-900 sm:p-10">
    <main class="mx-auto max-w-2xl rounded-xl bg-white p-6 shadow-sm sm:p-10">
        <div class="no-print mb-8 flex justify-between gap-3"><a href="{{ route('transaksi.show', $transaksi) }}"
                class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold">Kembali</a><button
                onclick="window.print()" class="rounded-lg bg-cyan-500 px-4 py-2 text-sm font-semibold">Cetak
                Struk</button></div>
        <header class="border-b border-dashed border-slate-300 pb-5 text-center">
            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-cyan-700">Apotek Natusi</p>
            <h1 class="mt-2 text-xl font-semibold">Struk Penjualan</h1>
            <p class="mt-2 font-mono text-sm text-slate-500">{{ $transaksi->no_faktur }}</p>
        </header>
        <dl class="grid grid-cols-2 gap-3 border-b border-dashed border-slate-300 py-5 text-sm">
            <div>
                <dt class="text-slate-500">Tanggal</dt>
                <dd class="mt-1 font-semibold">{{ $transaksi->tanggal->format('d-m-Y') }}</dd>
            </div>
            <div>
                <dt class="text-slate-500">Pembeli</dt>
                <dd class="mt-1 font-semibold">{{ $transaksi->nama_pembeli ?: '-' }}</dd>
            </div>
        </dl>
        <table class="mt-5 w-full text-sm">
            <thead>
                <tr class="border-b border-slate-200 text-left text-slate-500">
                    <th class="pb-3">Obat</th>
                    <th class="pb-3 text-center">Qty</th>
                    <th class="pb-3 text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach ($transaksi->details as $detail)
                    <tr>
                        <td class="py-3">
                            <p class="font-medium">{{ $detail->obat->nama_obat }}</p>
                            <p class="text-xs text-slate-500">{{ $detail->obat->kode_obat }} @ Rp
                                {{ number_format($detail->harga_satuan, 0, ',', '.') }}</p>
                        </td>
                        <td class="py-3 text-center">{{ $detail->qty }}</td>
                        <td class="py-3 text-right font-semibold">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="border-t border-slate-300">
                    <th colspan="2" class="pt-5 text-left text-base">Total</th>
                    <th class="pt-5 text-right text-base">Rp {{ number_format($transaksi->total, 0, ',', '.') }}</th>
                </tr>
            </tfoot>
        </table>
        <p class="mt-10 text-center text-xs text-slate-500">Terima kasih telah berbelanja.</p>
    </main>
</body>

</html>
