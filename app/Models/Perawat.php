<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Perawat extends Model
{
    protected $fillable = [
        'nama',
        'no_str',
        'telepon',
        'email',
        'alamat',
        'status'
    ];
}
