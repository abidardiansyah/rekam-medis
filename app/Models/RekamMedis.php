<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RekamMedis extends Model
{
    protected $table = 'rekam_medis';

    protected $fillable = [
        'record_number',
        'pasien_id',
        'dokter_id',
        'tanggal_kunjungan',
        'klinik',
        'keluhan_utama',
        'tekanan_darah',
        'suhu_badan',
        'nadi',
        'pernapasan',
        'berat_badan',
        'tinggi_badan',
        'bmi',
        'saturasi_oksigen',
        'diagnosa_code',
        'diagnosa',
        'rencana_tindakan',
        'resep_obat',
        'hasil_lab',
        'catatan_dokter',
        'status'
    ];

    protected $casts = [
        'tanggal_kunjungan' => 'date',
        'resep_obat' => 'array',
        'suhu_badan' => 'decimal:1',
        'berat_badan' => 'decimal:1',
        'tinggi_badan' => 'decimal:1',
        'bmi' => 'decimal:1'
    ];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }

    public function dokter()
    {
        return $this->belongsTo(Dokter::class);
    }
}
