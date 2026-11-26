<?php

namespace Database\Seeders;

use App\Models\Dokter;
use Illuminate\Database\Seeder;

class DokterSeeder extends Seeder
{
    public function run(): void
    {
        Dokter::create([
            'nama' => 'Dr. Ahmad Fauzi, Sp.PD',
            'spesialisasi' => 'Penyakit Dalam',
            'no_sip' => 'SIP-001-2024',
            'telepon' => '081234567890',
            'email' => 'ahmad.fauzi@rekammedis.com',
            'alamat' => 'Jl. Kesehatan No. 123, Jakarta',
            'status' => 'aktif',
            'foto' => 'https://i.pravatar.cc/150?img=12',
        ]);

        Dokter::create([
            'nama' => 'Dr. Siti Nurhaliza, Sp.A',
            'spesialisasi' => 'Anak',
            'no_sip' => 'SIP-002-2024',
            'telepon' => '081234567891',
            'email' => 'siti.nurhaliza@rekammedis.com',
            'alamat' => 'Jl. Kesehatan No. 124, Jakarta',
            'status' => 'aktif',
            'foto' => 'https://i.pravatar.cc/150?img=47',
        ]);

        Dokter::create([
            'nama' => 'Dr. Budi Santoso, Sp.JP',
            'spesialisasi' => 'Jantung',
            'no_sip' => 'SIP-003-2024',
            'telepon' => '081234567892',
            'email' => 'budi.santoso@rekammedis.com',
            'alamat' => 'Jl. Kesehatan No. 125, Jakarta',
            'status' => 'aktif',
            'foto' => 'https://i.pravatar.cc/150?img=33',
        ]);
    }
}
