<?php

namespace Database\Seeders;

use App\Models\Pasien;
use Illuminate\Database\Seeder;

class PasienSeeder extends Seeder
{
    public function run(): void
    {
        Pasien::create([
            'no_rm' => 'RM-2024-001',
            'nama' => 'Budi Santoso',
            'tanggal_lahir' => '1990-05-15',
            'jenis_kelamin' => 'L',
            'alamat' => 'Jl. Merdeka No. 45, Jakarta',
            'telepon' => '081234567896',
            'email' => 'budi.santoso@email.com',
            'golongan_darah' => 'A',
            'status' => 'aktif',
        ]);

        Pasien::create([
            'no_rm' => 'RM-2024-002',
            'nama' => 'Siti Aminah',
            'tanggal_lahir' => '1985-08-20',
            'jenis_kelamin' => 'P',
            'alamat' => 'Jl. Sudirman No. 78, Jakarta',
            'telepon' => '081234567897',
            'email' => 'siti.aminah@email.com',
            'golongan_darah' => 'B',
            'status' => 'aktif',
        ]);

        Pasien::create([
            'no_rm' => 'RM-2024-003',
            'nama' => 'Ahmad Yani',
            'tanggal_lahir' => '1995-12-10',
            'jenis_kelamin' => 'L',
            'alamat' => 'Jl. Gatot Subroto No. 90, Jakarta',
            'telepon' => '081234567898',
            'email' => 'ahmad.yani@email.com',
            'golongan_darah' => 'O',
            'status' => 'aktif',
        ]);

        Pasien::create([
            'no_rm' => 'RM-2024-004',
            'nama' => 'Dewi Sartika',
            'tanggal_lahir' => '2000-03-25',
            'jenis_kelamin' => 'P',
            'alamat' => 'Jl. Diponegoro No. 12, Jakarta',
            'telepon' => '081234567899',
            'email' => 'dewi.sartika@email.com',
            'golongan_darah' => 'AB',
            'status' => 'nonaktif',
        ]);
    }
}
