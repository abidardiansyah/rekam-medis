<?php

namespace Database\Seeders;

use App\Models\Perawat;
use Illuminate\Database\Seeder;

class PerawatSeeder extends Seeder
{
    public function run(): void
    {
        $perawats = [
            ['nama' => 'Ani Wijaya', 'no_str' => 'STR-P-001-2024', 'telepon' => '081234567893', 'email' => 'ani.wijaya@rekammedis.com', 'alamat' => 'Jl. Perawat No. 10, Jakarta', 'status' => 'aktif'],
            ['nama' => 'Dewi Lestari', 'no_str' => 'STR-P-002-2024', 'telepon' => '081234567894', 'email' => 'dewi.lestari@rekammedis.com', 'alamat' => 'Jl. Perawat No. 11, Jakarta', 'status' => 'aktif'],
            ['nama' => 'Rina Susanti', 'no_str' => 'STR-P-003-2024', 'telepon' => '081234567895', 'email' => 'rina.susanti@rekammedis.com', 'alamat' => 'Jl. Perawat No. 12, Jakarta', 'status' => 'aktif'],
            ['nama' => 'Budi Hartono', 'no_str' => 'STR-P-004-2024', 'telepon' => '081234567896', 'email' => 'budi.hartono@rekammedis.com', 'alamat' => 'Jl. Perawat No. 13, Jakarta', 'status' => 'aktif'],
            ['nama' => 'Siti Aminah', 'no_str' => 'STR-P-005-2024', 'telepon' => '081234567897', 'email' => 'siti.aminah@rekammedis.com', 'alamat' => 'Jl. Perawat No. 14, Jakarta', 'status' => 'aktif'],
            ['nama' => 'Joko Widodo', 'no_str' => 'STR-P-006-2024', 'telepon' => '081234567898', 'email' => 'joko.widodo@rekammedis.com', 'alamat' => 'Jl. Perawat No. 15, Jakarta', 'status' => 'aktif'],
            ['nama' => 'Lina Marlina', 'no_str' => 'STR-P-007-2024', 'telepon' => '081234567899', 'email' => 'lina.marlina@rekammedis.com', 'alamat' => 'Jl. Perawat No. 16, Jakarta', 'status' => 'aktif'],
            ['nama' => 'Hendra Gunawan', 'no_str' => 'STR-P-008-2024', 'telepon' => '081234567900', 'email' => 'hendra.gunawan@rekammedis.com', 'alamat' => 'Jl. Perawat No. 17, Jakarta', 'status' => 'aktif'],
        ];

        foreach ($perawats as $perawat) {
            Perawat::create($perawat);
        }
    }
}
