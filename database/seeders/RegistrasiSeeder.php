<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Registrasi;
use App\Models\Pasien;
use App\Models\Dokter;
use App\Models\ScheduleAssignment;
use Carbon\Carbon;

class RegistrasiSeeder extends Seeder
{
    public function run(): void
    {
        $pasiens = Pasien::all();
        $assignments = ScheduleAssignment::with(['assignable', 'workSchedule'])->where('status', 'active')->get();
        
        if ($pasiens->isEmpty() || $assignments->isEmpty()) {
            return;
        }
        
        $statusList = ['menunggu', 'dipanggil', 'selesai'];
        $jenisKunjungan = ['baru', 'kontrol'];
        $keluhanList = [
            'Demam tinggi sejak 3 hari',
            'Batuk dan pilek',
            'Sakit kepala berkepanjangan',
            'Nyeri perut',
            'Sesak napas',
            'Pusing dan mual',
            'Nyeri dada',
            'Diare',
            'Kontrol rutin',
            'Cek kesehatan umum'
        ];
        
        $hariMapping = [
            'Senin' => Carbon::now()->startOfWeek(),
            'Selasa' => Carbon::now()->startOfWeek()->addDay(),
            'Rabu' => Carbon::now()->startOfWeek()->addDays(2),
            'Kamis' => Carbon::now()->startOfWeek()->addDays(3),
            'Jumat' => Carbon::now()->startOfWeek()->addDays(4),
            'Sabtu' => Carbon::now()->startOfWeek()->addDays(5),
            'Minggu' => Carbon::now()->startOfWeek()->addDays(6),
        ];
        
        $counter = 1;
        
        foreach ($assignments as $assignment) {
            if ($assignment->assignable_type !== 'App\Models\Dokter') {
                continue;
            }
            
            $tanggal = $hariMapping[$assignment->day_of_week];
            $jumlahRegistrasi = rand(3, 5);
            
            for ($i = 0; $i < $jumlahRegistrasi; $i++) {
                $jamMulai = Carbon::parse($assignment->workSchedule->start_time);
                $jamKunjungan = $jamMulai->copy()->addMinutes($i * 30);
                
                $jamSelesai = Carbon::parse($assignment->workSchedule->end_time);
                if ($jamKunjungan->greaterThanOrEqualTo($jamSelesai)) {
                    break;
                }
                
                Registrasi::create([
                    'no_registrasi' => 'REG-' . $tanggal->format('Ymd') . '-' . str_pad($counter, 4, '0', STR_PAD_LEFT),
                    'pasien_id' => $pasiens->random()->id,
                    'dokter_id' => $assignment->assignable_id,
                    'jadwal_dokter_id' => null,
                    'tanggal_kunjungan' => $tanggal->format('Y-m-d'),
                    'jam_kunjungan' => $jamKunjungan->format('H:i:s'),
                    'keluhan' => $keluhanList[array_rand($keluhanList)],
                    'jenis_kunjungan' => $jenisKunjungan[array_rand($jenisKunjungan)],
                    'status' => $statusList[array_rand($statusList)]
                ]);
                
                $counter++;
            }
        }
    }
}
