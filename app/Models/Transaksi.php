<?php

namespace App\Models;

use Database\Factories\TransaksiFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaksi extends Model
{
    /** @use HasFactory<TransaksiFactory> */
    use HasFactory;

    protected $table = 'transaksi';

    protected $fillable = [
        'no_faktur',
        'tanggal',
        'nama_pembeli',
        'total',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
            'total' => 'double',
        ];
    }

    public function details(): HasMany
    {
        return $this->hasMany(TransaksiDetail::class, 'transaksi_id');
    }
}
