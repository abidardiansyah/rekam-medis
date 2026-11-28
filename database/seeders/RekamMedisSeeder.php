<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RekamMedis;
use App\Models\Pasien;
use App\Models\Dokter;
use Carbon\Carbon;

class RekamMedisSeeder extends Seeder
{
    public function run(): void
    {
        $pasiens = Pasien::all();
        $dokters = Dokter::all();
        
        if ($pasiens->isEmpty() || $dokters->isEmpty()) {
            return;
        }

        $diagnoses = [
            ['code' => 'I10', 'name' => 'Hipertensi Esensial'],
            ['code' => 'J00', 'name' => 'Nasofaringitis Akut (Flu Biasa)'],
            ['code' => 'K29.7', 'name' => 'Gastritis'],
            ['code' => 'M54.5', 'name' => 'Nyeri Punggung Bawah'],
            ['code' => 'J02.9', 'name' => 'Faringitis Akut'],
            ['code' => 'A09', 'name' => 'Gastroenteritis Infeksi'],
            ['code' => 'R50.9', 'name' => 'Demam'],
            ['code' => 'J20.9', 'name' => 'Bronkitis Akut'],
            ['code' => 'R51', 'name' => 'Sakit Kepala'],
            ['code' => 'H10.9', 'name' => 'Konjungtivitis'],
            ['code' => 'E11', 'name' => 'Diabetes Mellitus Tipe 2'],
            ['code' => 'J45', 'name' => 'Asma'],
        ];

        $medications = [
            ['medication' => 'Paracetamol 500mg', 'dosage' => '500mg', 'frequency' => '3x sehari', 'duration' => '5 hari'],
            ['medication' => 'Amoxicillin 500mg', 'dosage' => '500mg', 'frequency' => '3x sehari', 'duration' => '7 hari'],
            ['medication' => 'Omeprazole 20mg', 'dosage' => '20mg', 'frequency' => '1x sehari', 'duration' => '14 hari'],
            ['medication' => 'Ibuprofen 400mg', 'dosage' => '400mg', 'frequency' => '2x sehari', 'duration' => '5 hari'],
            ['medication' => 'Metformin 500mg', 'dosage' => '500mg', 'frequency' => '2x sehari', 'duration' => '30 hari'],
            ['medication' => 'Amlodipine 5mg', 'dosage' => '5mg', 'frequency' => '1x sehari', 'duration' => '30 hari'],
        ];

        $keluhanList = [
            'Demam tinggi sejak 3 hari',
            'Batuk dan pilek',
            'Sakit kepala berkepanjangan',
            'Nyeri perut',
            'Sesak napas',
            'Pusing dan mual',
            'Nyeri dada',
            'Diare',
            'Kontrol rutin diabetes',
            'Kontrol tekanan darah'
        ];

        $today = Carbon::now();
        $counter = 1;

        // Generate 5 rekam medis untuk setiap pasien
        foreach ($pasiens->take(10) as $pasien) {
            for ($i = 0; $i < 5; $i++) {
                $date = $today->copy()->subDays(rand(1, 90));
                $diag = $diagnoses[array_rand($diagnoses)];
                $weight = rand(50, 90);
                $height = rand(155, 180);
                $bmi = round($weight / (($height / 100) ** 2), 1);

                RekamMedis::create([
                    'record_number' => 'MR-' . $date->format('Ymd') . '-' . str_pad($counter, 4, '0', STR_PAD_LEFT),
                    'pasien_id' => $pasien->id,
                    'dokter_id' => $dokters->random()->id,
                    'tanggal_kunjungan' => $date->format('Y-m-d'),
                    'klinik' => 'Poli Umum',
                    'keluhan_utama' => $keluhanList[array_rand($keluhanList)],
                    'tekanan_darah' => rand(110, 140) . '/' . rand(70, 90),
                    'suhu_badan' => rand(360, 390) / 10,
                    'nadi' => rand(60, 100),
                    'pernapasan' => rand(16, 24),
                    'berat_badan' => $weight,
                    'tinggi_badan' => $height,
                    'bmi' => $bmi,
                    'saturasi_oksigen' => rand(95, 100),
                    'diagnosa_code' => $diag['code'],
                    'diagnosa' => $diag['name'],
                    'rencana_tindakan' => 'Terapi medikamentosa dan istirahat cukup',
                    'resep_obat' => json_encode([$medications[array_rand($medications)]]),
                    'hasil_lab' => rand(0, 1) ? 'Pemeriksaan darah lengkap: Normal' : null,
                    'catatan_dokter' => 'Kontrol kembali jika keluhan tidak membaik dalam 3-5 hari',
                    'status' => ['draft', 'completed', 'reviewed'][array_rand(['draft', 'completed', 'reviewed'])],
                    'created_at' => $date,
                    'updated_at' => $date,
                ]);
                
                $counter++;
            }
        }
    }
}
