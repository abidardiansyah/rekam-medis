<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Registrasi extends Model
{
    protected $fillable = [
        'no_registrasi',
        'pasien_id',
        'dokter_id',
        'jadwal_dokter_id',
        'tanggal_kunjungan',
        'jam_kunjungan',
        'keluhan',
        'jenis_kunjungan',
        'status'
    ];

    public function pasien(): BelongsTo
    {
        return $this->belongsTo(Pasien::class);
    }

    public function dokter(): BelongsTo
    {
        return $this->belongsTo(Dokter::class);
    }

    public function jadwalDokter(): BelongsTo
    {
        return $this->belongsTo(JadwalDokter::class);
    }
}
