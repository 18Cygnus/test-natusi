<?php

namespace App\Models;

use Database\Factories\ObatFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Obat extends Model
{
    /** @use HasFactory<ObatFactory> */
    use HasFactory;

    protected $table = 'obat';

    protected $primaryKey = 'id_obat';

    protected $fillable = [
        'kode_obat',
        'nama_obat',
        'satuan_obat',
        'harga_obat',
        'stok_obat',
    ];

    protected function casts(): array
    {
        return [
            'harga_obat' => 'double',
            'stok_obat' => 'integer',
        ];
    }

    public function detailTransaksis(): HasMany
    {
        return $this->hasMany(TransaksiDetail::class, 'obat_id', 'id_obat');
    }
}
