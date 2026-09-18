@extends('layouts.app')
@section('title', 'Edit Distributor')
@section('heading', 'Edit Distributor')
@section('content')<div class="max-w-4xl rounded-xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
        <div class="mb-6">
            <p class="text-sm text-slate-500">{{ $distributor->nama_distributor }}</p>
            <h3 class="mt-1 text-xl font-semibold">Perbarui distributor</h3>
        </div>
        <form method="POST" action="{{ route('distributor.update', $distributor) }}">@method('PUT')
            @include('distributor._form', ['submitLabel' => 'Simpan Perubahan'])</form>
</div>@endsection
