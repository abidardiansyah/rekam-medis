<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Apotek extends Model
{
    protected $fillable = [
        'kode_obat',
        'nama_obat',
        'kategori',
        'satuan',
        'stok',
        'harga',
        'tanggal_kadaluarsa',
        'deskripsi',
        'status'
    ];

    protected $casts = [
        'tanggal_kadaluarsa' => 'date',
        'harga' => 'decimal:2'
    ];
}
