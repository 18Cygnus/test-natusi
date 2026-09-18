@extends('layouts.app')
@section('title', 'Tambah Distributor')
@section('heading', 'Tambah Distributor')
@section('content')<div class="max-w-4xl rounded-xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
        <div class="mb-6">
            <p class="text-sm text-slate-500">Mitra pemasok</p>
            <h3 class="mt-1 text-xl font-semibold">Informasi distributor</h3>
        </div>
        <form method="POST" action="{{ route('distributor.store') }}">@include('distributor._form', ['submitLabel' => 'Simpan Distributor'])</form>
</div>@endsection
