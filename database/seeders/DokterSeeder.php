<?php

namespace Database\Seeders;

use App\Models\Dokter;
use Illuminate\Database\Seeder;

class DokterSeeder extends Seeder
{
    public function run(): void
    {
        $dokters = [
            ['nama' => 'Dr. Ahmad Fauzi, Sp.PD', 'spesialisasi' => 'Penyakit Dalam', 'no_sip' => 'SIP-001-2024', 'telepon' => '081234567890', 'email' => 'ahmad.fauzi@rekammedis.com', 'alamat' => 'Jl. Kesehatan No. 123, Jakarta', 'status' => 'aktif', 'foto' => 'https://i.pravatar.cc/150?img=12'],
            ['nama' => 'Dr. Siti Nurhaliza, Sp.A', 'spesialisasi' => 'Anak', 'no_sip' => 'SIP-002-2024', 'telepon' => '081234567891', 'email' => 'siti.nurhaliza@rekammedis.com', 'alamat' => 'Jl. Kesehatan No. 124, Jakarta', 'status' => 'aktif', 'foto' => 'https://i.pravatar.cc/150?img=47'],
            ['nama' => 'Dr. Budi Santoso, Sp.JP', 'spesialisasi' => 'Jantung', 'no_sip' => 'SIP-003-2024', 'telepon' => '081234567892', 'email' => 'budi.santoso@rekammedis.com', 'alamat' => 'Jl. Kesehatan No. 125, Jakarta', 'status' => 'aktif', 'foto' => 'https://i.pravatar.cc/150?img=33'],
            ['nama' => 'Dr. Rina Wijaya, Sp.OG', 'spesialisasi' => 'Kandungan', 'no_sip' => 'SIP-004-2024', 'telepon' => '081234567893', 'email' => 'rina.wijaya@rekammedis.com', 'alamat' => 'Jl. Kesehatan No. 126, Jakarta', 'status' => 'aktif', 'foto' => 'https://i.pravatar.cc/150?img=5'],
            ['nama' => 'Dr. Hendra Gunawan, Sp.B', 'spesialisasi' => 'Bedah', 'no_sip' => 'SIP-005-2024', 'telepon' => '081234567894', 'email' => 'hendra.gunawan@rekammedis.com', 'alamat' => 'Jl. Kesehatan No. 127, Jakarta', 'status' => 'aktif', 'foto' => 'https://i.pravatar.cc/150?img=15'],
            ['nama' => 'Dr. Maya Sari, Sp.M', 'spesialisasi' => 'Mata', 'no_sip' => 'SIP-006-2024', 'telepon' => '081234567895', 'email' => 'maya.sari@rekammedis.com', 'alamat' => 'Jl. Kesehatan No. 128, Jakarta', 'status' => 'aktif', 'foto' => 'https://i.pravatar.cc/150?img=9'],
            ['nama' => 'Dr. Agus Prasetyo, Sp.THT', 'spesialisasi' => 'THT', 'no_sip' => 'SIP-007-2024', 'telepon' => '081234567896', 'email' => 'agus.prasetyo@rekammedis.com', 'alamat' => 'Jl. Kesehatan No. 129, Jakarta', 'status' => 'aktif', 'foto' => 'https://i.pravatar.cc/150?img=68'],
            ['nama' => 'Dr. Dewi Lestari, Sp.KK', 'spesialisasi' => 'Kulit dan Kelamin', 'no_sip' => 'SIP-008-2024', 'telepon' => '081234567897', 'email' => 'dewi.lestari@rekammedis.com', 'alamat' => 'Jl. Kesehatan No. 130, Jakarta', 'status' => 'aktif', 'foto' => 'https://i.pravatar.cc/150?img=20'],
            ['nama' => 'Dr. Rudi Hartono, Sp.S', 'spesialisasi' => 'Saraf', 'no_sip' => 'SIP-009-2024', 'telepon' => '081234567898', 'email' => 'rudi.hartono@rekammedis.com', 'alamat' => 'Jl. Kesehatan No. 131, Jakarta', 'status' => 'aktif', 'foto' => 'https://i.pravatar.cc/150?img=51'],
            ['nama' => 'Dr. Lina Marlina, Sp.PK', 'spesialisasi' => 'Patologi Klinik', 'no_sip' => 'SIP-010-2024', 'telepon' => '081234567899', 'email' => 'lina.marlina@rekammedis.com', 'alamat' => 'Jl. Kesehatan No. 132, Jakarta', 'status' => 'aktif', 'foto' => 'https://i.pravatar.cc/150?img=32'],
            ['nama' => 'Dr. Bambang Suryadi, Sp.U', 'spesialisasi' => 'Urologi', 'no_sip' => 'SIP-011-2024', 'telepon' => '081234567900', 'email' => 'bambang.suryadi@rekammedis.com', 'alamat' => 'Jl. Kesehatan No. 133, Jakarta', 'status' => 'aktif', 'foto' => 'https://i.pravatar.cc/150?img=60'],
            ['nama' => 'Dr. Fitri Handayani, Sp.An', 'spesialisasi' => 'Anestesi', 'no_sip' => 'SIP-012-2024', 'telepon' => '081234567901', 'email' => 'fitri.handayani@rekammedis.com', 'alamat' => 'Jl. Kesehatan No. 134, Jakarta', 'status' => 'aktif', 'foto' => 'https://i.pravatar.cc/150?img=44'],
            ['nama' => 'Dr. Irfan Hakim, Sp.Or', 'spesialisasi' => 'Ortopedi', 'no_sip' => 'SIP-013-2024', 'telepon' => '081234567902', 'email' => 'irfan.hakim@rekammedis.com', 'alamat' => 'Jl. Kesehatan No. 135, Jakarta', 'status' => 'aktif', 'foto' => 'https://i.pravatar.cc/150?img=56'],
            ['nama' => 'Dr. Nurul Aini, Sp.Rad', 'spesialisasi' => 'Radiologi', 'no_sip' => 'SIP-014-2024', 'telepon' => '081234567903', 'email' => 'nurul.aini@rekammedis.com', 'alamat' => 'Jl. Kesehatan No. 136, Jakarta', 'status' => 'aktif', 'foto' => 'https://i.pravatar.cc/150?img=23'],
            ['nama' => 'Dr. Yusuf Rahman, Sp.P', 'spesialisasi' => 'Paru', 'no_sip' => 'SIP-015-2024', 'telepon' => '081234567904', 'email' => 'yusuf.rahman@rekammedis.com', 'alamat' => 'Jl. Kesehatan No. 137, Jakarta', 'status' => 'aktif', 'foto' => 'https://i.pravatar.cc/150?img=70'],
        ];

        foreach ($dokters as $dokter) {
            Dokter::create($dokter);
        }
    }
}
