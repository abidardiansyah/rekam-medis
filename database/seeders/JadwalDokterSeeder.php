<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\JadwalDokter;
use App\Models\Dokter;

class JadwalDokterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dokters = Dokter::all();
        
        if ($dokters->isEmpty()) {
            return;
        }
        
        $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        $ruanganList = ['Ruang 101', 'Ruang 102', 'Ruang 103', 'Ruang 201', 'Ruang 202'];
        
        foreach ($dokters->take(3) as $index => $dokter) {
            // Setiap dokter punya 2-3 jadwal
            $jumlahJadwal = rand(2, 3);
            
            for ($i = 0; $i < $jumlahJadwal; $i++) {
                JadwalDokter::create([
                    'dokter_id' => $dokter->id,
                    'hari' => $hariList[($index * 2 + $i) % count($hariList)],
                    'jam_mulai' => sprintf('%02d:00:00', 8 + ($i * 3)),
                    'jam_selesai' => sprintf('%02d:00:00', 11 + ($i * 3)),
                    'ruangan' => $ruanganList[$index % count($ruanganList)],
                    'kuota' => rand(10, 30),
                    'status' => $i == 0 ? 'aktif' : (rand(0, 1) ? 'aktif' : 'nonaktif')
                ]);
            }
        }
    }
}
