<?php

namespace App\Http\Controllers;

use App\Http\Requests\DistributorRequest;
use App\Models\Distributor;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DistributorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $distributors = Distributor::query()->orderBy('nama_distributor')->paginate(10);

        return view('distributor.index', compact('distributors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('distributor.create', ['distributor' => new Distributor]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DistributorRequest $request): RedirectResponse
    {
        Distributor::create($request->validated());

        return redirect()->route('distributor.index')->with('success', 'Distributor berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Distributor $distributor): View
    {
        return view('distributor.show', compact('distributor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Distributor $distributor): View
    {
        return view('distributor.edit', compact('distributor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DistributorRequest $request, Distributor $distributor): RedirectResponse
    {
        $distributor->update($request->validated());

        return redirect()->route('distributor.index')->with('success', 'Distributor berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Distributor $distributor): RedirectResponse
    {
        $distributor->delete();

        return redirect()->route('distributor.index')->with('success', 'Distributor berhasil dihapus.');
    }

    public function map(): View
    {
        $distributors = Distributor::query()
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->orderBy('nama_distributor')
            ->get();

        return view('distributor.map', compact('distributors'));
    }
}
