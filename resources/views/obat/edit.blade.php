@extends('layouts.app')
@section('title', 'Edit Obat')
@section('heading', 'Edit Obat')
@section('content')
    <div class="max-w-3xl rounded-xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
        <div class="mb-6">
            <p class="text-sm text-slate-500">{{ $obat->kode_obat }}</p>
            <h3 class="mt-1 text-xl font-semibold">Perbarui informasi obat</h3>
        </div>
        <form method="POST" action="{{ route('obat.update', $obat) }}">@method('PUT') @include('obat._form', ['submitLabel' => 'Simpan Perubahan'])</form>
    </div>
@endsection
