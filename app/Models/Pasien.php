<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    protected $fillable = [
        'no_rm',
        'nama',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'telepon',
        'email',
        'golongan_darah',
        'status'
    ];
}
