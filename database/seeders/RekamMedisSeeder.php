<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RekamMedis;
use Carbon\Carbon;

class RekamMedisSeeder extends Seeder
{
    public function run(): void
    {
        $diagnoses = [
            ['code' => 'I10', 'name' => 'Essential Hypertension'],
            ['code' => 'J00', 'name' => 'Acute Nasopharyngitis (Common Cold)'],
            ['code' => 'K29.7', 'name' => 'Gastritis'],
            ['code' => 'M54.5', 'name' => 'Low Back Pain'],
            ['code' => 'J02.9', 'name' => 'Acute Pharyngitis'],
            ['code' => 'A09', 'name' => 'Infectious Gastroenteritis'],
            ['code' => 'R50.9', 'name' => 'Fever, Unspecified'],
            ['code' => 'J20.9', 'name' => 'Acute Bronchitis'],
            ['code' => 'R51', 'name' => 'Headache'],
            ['code' => 'H10.9', 'name' => 'Conjunctivitis'],
        ];

        $medications = [
            ['medication' => 'Paracetamol 500mg', 'dosage' => '500mg', 'frequency' => '3x daily', 'duration' => '5 days'],
            ['medication' => 'Amoxicillin 500mg', 'dosage' => '500mg', 'frequency' => '3x daily', 'duration' => '7 days'],
            ['medication' => 'Omeprazole 20mg', 'dosage' => '20mg', 'frequency' => '1x daily', 'duration' => '14 days'],
            ['medication' => 'Ibuprofen 400mg', 'dosage' => '400mg', 'frequency' => '2x daily', 'duration' => '5 days'],
        ];

        $records = [];
        $today = Carbon::now();

        // Pasien 1 - 10 records
        for ($i = 0; $i < 10; $i++) {
            $date = $today->copy()->subDays($i * 3);
            $diag = $diagnoses[$i % count($diagnoses)];
            $weight = 65 + ($i % 5);
            $height = 170;
            $bmi = round($weight / (($height / 100) ** 2), 1);

            $records[] = [
                'record_number' => 'MR-' . $date->format('Ymd') . '-' . str_pad($i + 1, 3, '0', STR_PAD_LEFT),
                'pasien_id' => 1,
                'dokter_id' => ($i % 3) + 1,
                'tanggal_kunjungan' => $date->format('Y-m-d'),
                'klinik' => 'General',
                'keluhan_utama' => 'Patient reports symptoms for ' . ($i + 1) . ' days',
                'tekanan_darah' => (110 + $i * 2) . '/' . (70 + $i),
                'suhu_badan' => 36.5 + ($i % 3) * 0.5,
                'nadi' => 70 + ($i * 2),
                'pernapasan' => 18 + ($i % 3),
                'berat_badan' => $weight,
                'tinggi_badan' => $height,
                'bmi' => $bmi,
                'saturasi_oksigen' => 97 + ($i % 3),
                'diagnosa_code' => $diag['code'],
                'diagnosa' => $diag['name'],
                'rencana_tindakan' => 'Conservative management with medications and rest',
                'resep_obat' => json_encode([$medications[$i % count($medications)]]),
                'hasil_lab' => $i % 3 == 0 ? 'Blood test: Normal' : null,
                'catatan_dokter' => 'Follow up in 1 week if symptoms persist',
                'status' => $i < 2 ? 'draft' : ($i < 5 ? 'completed' : 'reviewed'),
                'created_at' => $date,
                'updated_at' => $date,
            ];
        }

        // Pasien 2 - 10 records
        for ($i = 0; $i < 10; $i++) {
            $date = $today->copy()->subDays($i * 4);
            $diag = $diagnoses[($i + 5) % count($diagnoses)];
            $weight = 55 + ($i % 4);
            $height = 165;
            $bmi = round($weight / (($height / 100) ** 2), 1);

            $records[] = [
                'record_number' => 'MR-' . $date->format('Ymd') . '-' . str_pad($i + 11, 3, '0', STR_PAD_LEFT),
                'pasien_id' => 2,
                'dokter_id' => ($i % 3) + 1,
                'tanggal_kunjungan' => $date->format('Y-m-d'),
                'klinik' => 'Internal Medicine',
                'keluhan_utama' => 'Experiencing discomfort for ' . ($i + 2) . ' days',
                'tekanan_darah' => (115 + $i) . '/' . (75 + $i),
                'suhu_badan' => 36.8 + ($i % 2) * 0.4,
                'nadi' => 75 + ($i * 2),
                'pernapasan' => 16 + ($i % 4),
                'berat_badan' => $weight,
                'tinggi_badan' => $height,
                'bmi' => $bmi,
                'saturasi_oksigen' => 96 + ($i % 4),
                'diagnosa_code' => $diag['code'],
                'diagnosa' => $diag['name'],
                'rencana_tindakan' => 'Medication therapy and lifestyle modifications',
                'resep_obat' => json_encode([$medications[($i + 1) % count($medications)]]),
                'hasil_lab' => $i % 4 == 0 ? 'Urinalysis: Normal' : null,
                'catatan_dokter' => 'Monitor symptoms and return if worsening',
                'status' => $i < 3 ? 'completed' : 'reviewed',
                'created_at' => $date,
                'updated_at' => $date,
            ];
        }

        foreach ($records as $record) {
            RekamMedis::create($record);
        }
    }
}
