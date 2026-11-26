<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Registrasi;
use App\Models\Pasien;
use App\Models\Dokter;
use App\Models\JadwalDokter;
use Carbon\Carbon;

class RegistrasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing registrasi
        Registrasi::truncate();
        
        $pasiens = Pasien::all();
        $jadwals = JadwalDokter::where('status', 'aktif')->get();
        
        if ($pasiens->isEmpty() || $jadwals->isEmpty()) {
            return;
        }
        
        $statusList = ['menunggu', 'dipanggil'];
        $jenisKunjungan = ['baru', 'kontrol'];
        
        // Mapping hari ke tanggal minggu ini
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
        
        // Generate registrasi untuk setiap jadwal
        foreach ($jadwals as $jadwal) {
            // Ambil tanggal sesuai hari jadwal
            $tanggal = $hariMapping[$jadwal->hari];
            
            // Buat 2-3 registrasi per jadwal
            $jumlahRegistrasi = rand(2, 3);
            
            for ($i = 0; $i < $jumlahRegistrasi; $i++) {
                // Hitung jam kunjungan (mulai dari jam_mulai + interval)
                $jamMulai = Carbon::parse($jadwal->jam_mulai);
                $jamKunjungan = $jamMulai->copy()->addMinutes($i * 30); // Interval 30 menit
                
                // Pastikan tidak melebihi jam_selesai
                $jamSelesai = Carbon::parse($jadwal->jam_selesai);
                if ($jamKunjungan->greaterThanOrEqualTo($jamSelesai)) {
                    break;
                }
                
                Registrasi::create([
                    'no_registrasi' => 'REG-' . $tanggal->format('Ymd') . '-' . str_pad($counter, 4, '0', STR_PAD_LEFT),
                    'pasien_id' => $pasiens->random()->id,
                    'dokter_id' => $jadwal->dokter_id,
                    'jadwal_dokter_id' => $jadwal->id,
                    'tanggal_kunjungan' => $tanggal->format('Y-m-d'),
                    'jam_kunjungan' => $jamKunjungan->format('H:i:s'),
                    'keluhan' => 'Keluhan pasien ' . $counter,
                    'jenis_kunjungan' => $jenisKunjungan[array_rand($jenisKunjungan)],
                    'status' => $statusList[array_rand($statusList)]
                ]);
                
                $counter++;
            }
        }
    }
}
