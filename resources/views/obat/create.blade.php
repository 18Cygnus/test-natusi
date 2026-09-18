@extends('layouts.app')
@section('title', 'Tambah Obat')
@section('heading', 'Tambah Obat')
@section('content')
    <div class="max-w-3xl rounded-xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
        <div class="mb-6">
            <p class="text-sm text-slate-500">Master data</p>
            <h3 class="mt-1 text-xl font-semibold">Informasi obat baru</h3>
        </div>
        <form method="POST" action="{{ route('obat.store') }}">@include('obat._form', ['submitLabel' => 'Simpan Obat'])</form>
    </div>
@endsection
