<?php

namespace App\Http\Controllers;

use App\Http\Requests\ObatRequest;
use App\Models\Obat;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ObatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $obats = Obat::query()
            ->when(request('q'), function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('nama_obat', 'like', "%{$search}%")
                        ->orWhere('kode_obat', 'like', "%{$search}%");
                });
            })
            ->latest('id_obat')
            ->paginate(10)
            ->withQueryString();

        return view('obat.index', compact('obats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('obat.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ObatRequest $request): RedirectResponse
    {
        Obat::create($request->validated());

        return redirect()->route('obat.index')->with('success', 'Obat berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Obat $obat): View
    {
        return view('obat.show', compact('obat'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Obat $obat): View
    {
        return view('obat.edit', compact('obat'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ObatRequest $request, Obat $obat): RedirectResponse
    {
        $obat->update($request->validated());

        return redirect()->route('obat.index')->with('success', 'Obat berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Obat $obat): RedirectResponse
    {
        $obat->delete();

        return redirect()->route('obat.index')->with('success', 'Obat berhasil dihapus.');
    }
}
