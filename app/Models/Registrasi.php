<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Registrasi extends Model
{
    protected $fillable = [
        'no_registrasi',
        'no_antrean',
        'pasien_id',
        'dokter_id',
        'jadwal_dokter_id',
        'work_schedule_id',
        'schedule_assignment_id',
        'tanggal_kunjungan',
        'jam_kunjungan',
        'jam_mulai',
        'jam_selesai',
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

    public function workSchedule(): BelongsTo
    {
        return $this->belongsTo(WorkSchedule::class);
    }

    public function scheduleAssignment(): BelongsTo
    {
        return $this->belongsTo(ScheduleAssignment::class);
    }
}
