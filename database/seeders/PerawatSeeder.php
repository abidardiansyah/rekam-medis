<?php

namespace Database\Seeders;

use App\Models\Perawat;
use Illuminate\Database\Seeder;

class PerawatSeeder extends Seeder
{
    public function run(): void
    {
        Perawat::create([
            'nama' => 'Ani Wijaya',
            'no_str' => 'STR-P-001-2024',
            'telepon' => '081234567893',
            'email' => 'ani.wijaya@rekammedis.com',
            'alamat' => 'Jl. Perawat No. 10, Jakarta',
            'status' => 'aktif',
        ]);

        Perawat::create([
            'nama' => 'Dewi Lestari',
            'no_str' => 'STR-P-002-2024',
            'telepon' => '081234567894',
            'email' => 'dewi.lestari@rekammedis.com',
            'alamat' => 'Jl. Perawat No. 11, Jakarta',
            'status' => 'aktif',
        ]);

        Perawat::create([
            'nama' => 'Rina Susanti',
            'no_str' => 'STR-P-003-2024',
            'telepon' => '081234567895',
            'email' => 'rina.susanti@rekammedis.com',
            'alamat' => 'Jl. Perawat No. 12, Jakarta',
            'status' => 'nonaktif',
        ]);
    }
}
