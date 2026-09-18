<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Obat;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StokObatController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Obat::query();

        if ($search = $request->query('q')) {
            $query->where(function ($query) use ($search): void {
                $query->where('nama_obat', 'like', "%{$search}%")
                    ->orWhere('kode_obat', 'like', "%{$search}%");
            });
        }

        return response()->json(['success' => true, 'data' => $query->orderBy('nama_obat')->get()]);
    }

    public function show(int $id): JsonResponse
    {
        $obat = Obat::query()->findOrFail($id);

        return response()->json(['success' => true, 'data' => $obat]);
    }
}
