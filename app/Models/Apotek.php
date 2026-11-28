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
        'tanggal_kadaluarsa',
        'deskripsi',
        'status'
    ];

    protected $casts = [
        'tanggal_kadaluarsa' => 'date'
    ];
}
