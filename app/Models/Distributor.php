<?php

namespace App\Models;

use Database\Factories\DistributorFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Distributor extends Model
{
    /** @use HasFactory<DistributorFactory> */
    use HasFactory;

    protected $table = 'distributor';

    protected $fillable = [
        'nama_distributor',
        'alamat',
        'kota',
        'telepon',
        'email',
        'latitude',
        'longitude',
    ];

    protected function casts(): array
    {
        return [
            'latitude' => 'double',
            'longitude' => 'double',
        ];
    }
}
