<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PesananRequest;
use App\Models\Obat;
use App\Models\Transaksi;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PesananController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Transaksi::query()->with('details.obat')->orderByDesc('tanggal');

        if ($request->filled('from')) {
            $query->whereDate('tanggal', '>=', $request->query('from'));
        }
        if ($request->filled('to')) {
            $query->whereDate('tanggal', '<=', $request->query('to'));
        }

        $perPage = min(max($request->integer('per_page', 20), 1), 100);

        return response()->json(['success' => true, 'data' => $query->paginate($perPage)]);
    }

    public function store(PesananRequest $request): JsonResponse
    {
        try {
            $transaksi = DB::transaction(function () use ($request): Transaksi {
                $items = collect($request->validated('items'));
                $obats = Obat::query()
                    ->whereIn('id_obat', $items->pluck('obat_id'))
                    ->lockForUpdate()
                    ->get()
                    ->keyBy('id_obat');
                $total = 0;
                $preparedItems = [];

                foreach ($items as $item) {
                    $obat = $obats->get($item['obat_id']);
                    if ($obat === null || $obat->stok_obat < $item['qty']) {
                        throw ValidationException::withMessages([
                            'stok' => 'Stok obat tidak cukup.',
                        ]);
                    }

                    $subtotal = $obat->harga_obat * $item['qty'];
                    $total += $subtotal;
                    $preparedItems[] = compact('obat', 'item', 'subtotal');
                }

                $transaksi = Transaksi::create([
                    'no_faktur' => $this->generateNoFaktur(),
                    'tanggal' => now()->toDateString(),
                    'nama_pembeli' => $request->validated('nama_pembeli'),
                    'total' => $total,
                ]);

                foreach ($preparedItems as $prepared) {
                    $transaksi->details()->create([
                        'obat_id' => $prepared['obat']->id_obat,
                        'qty' => $prepared['item']['qty'],
                        'harga_satuan' => $prepared['obat']->harga_obat,
                        'subtotal' => $prepared['subtotal'],
                    ]);
                    $prepared['obat']->decrement('stok_obat', $prepared['item']['qty']);
                }

                return $transaksi;
            });
        } catch (ValidationException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Pesanan gagal.',
                'errors' => $exception->errors(),
            ], 422);
        }

        return response()->json([
            'success' => true,
            'message' => 'Pesanan berhasil dibuat.',
            'data' => $transaksi->load('details.obat'),
        ], 201);
    }

    public function show(int $id): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => Transaksi::query()->with('details.obat')->findOrFail($id),
        ]);
    }

    private function generateNoFaktur(): string
    {
        $today = now()->format('Ymd');
        $count = Transaksi::query()->whereDate('tanggal', now()->toDateString())->lockForUpdate()->count() + 1;

        return 'INV-'.$today.'-'.str_pad((string) $count, 4, '0', STR_PAD_LEFT);
    }
}
