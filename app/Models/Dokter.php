<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dokter extends Model
{
    protected $fillable = [
        'nama',
        'spesialisasi',
        'no_sip',
        'telepon',
        'email',
        'alamat',
        'status'
    ];
    
    public function jadwalDokters()
    {
        return $this->hasMany(JadwalDokter::class, 'dokter_id');
    }
}
