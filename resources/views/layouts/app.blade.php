<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Apotek Natusi')</title>
    @stack('styles')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-100 text-slate-900">
    <div class="min-h-screen lg:flex">
        <aside class="bg-slate-950 px-5 py-6 text-white lg:flex lg:w-64 lg:flex-col">
            <div class="mb-8">
                <p class="text-xs font-semibold uppercase tracking-[0.3em] text-cyan-300">Natusi</p>
                <h1 class="mt-2 text-2xl font-semibold">Apotek Panel</h1>
            </div>
            <nav class="flex gap-2 lg:flex-col">
                <a href="{{ route('obat.index') }}" class="rounded-lg px-4 py-3 text-sm font-medium transition {{ request()->routeIs('obat.*') ? 'bg-cyan-400 text-slate-950' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">Master Obat</a>
                <a href="{{ route('transaksi.index') }}" class="rounded-lg px-4 py-3 text-sm font-medium transition {{ request()->routeIs('transaksi.*') ? 'bg-cyan-400 text-slate-950' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">Transaksi Penjualan</a>
                <div class="rounded-lg {{ request()->routeIs('laporan.*') ? 'bg-slate-800' : '' }}">
                    <p class="px-4 py-3 text-sm font-medium {{ request()->routeIs('laporan.*') ? 'text-cyan-300' : 'text-slate-300' }}">Laporan</p>
                    <div class="space-y-1 px-2 pb-2">
                        <a href="{{ route('laporan.stok') }}" class="block rounded-lg px-3 py-2 text-sm transition {{ request()->routeIs('laporan.stok') ? 'bg-cyan-400 font-semibold text-slate-950' : 'text-slate-400 hover:bg-slate-700 hover:text-white' }}">Sisa Stok</a>
                        <a href="{{ route('laporan.penjualan') }}" class="block rounded-lg px-3 py-2 text-sm transition {{ request()->routeIs('laporan.penjualan') ? 'bg-cyan-400 font-semibold text-slate-950' : 'text-slate-400 hover:bg-slate-700 hover:text-white' }}">Penjualan</a>
                    </div>
                </div>
                <a href="{{ route('distributor.index') }}" class="rounded-lg px-4 py-3 text-sm font-medium transition {{ request()->routeIs('distributor.*') ? 'bg-cyan-400 text-slate-950' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">Distributor</a>
            </nav>
            <p class="mt-auto hidden pt-8 text-xs leading-5 text-slate-500 lg:block">Kelola inventori dan penjualan dengan data yang rapi.</p>
        </aside>

        <main class="min-w-0 flex-1">
            <header class="border-b border-slate-200 bg-white px-5 py-5 sm:px-8">
                <div class="mx-auto flex max-w-7xl items-center justify-between gap-4">
                    <div>
                        <p class="text-sm text-slate-500">Apotek Natusi</p>
                        <h2 class="text-xl font-semibold">@yield('heading', 'Dashboard')</h2>
                    </div>
                    <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">Operasional</span>
                </div>
            </header>
            <div class="mx-auto max-w-7xl px-5 py-8 sm:px-8">
                @if (session('success'))
                    <div class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">{{ session('success') }}</div>
                @endif
                @if ($errors->any())
                    <div class="mb-6 rounded-lg border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800">
                        <p class="font-semibold">Periksa kembali input Anda.</p>
                        <ul class="mt-2 list-disc space-y-1 pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @yield('content')
            </div>
        </main>
    </div>
    @stack('scripts')
</body>
</html>
