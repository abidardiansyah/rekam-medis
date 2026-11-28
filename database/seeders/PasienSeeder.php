<?php

namespace Database\Seeders;

use App\Models\Pasien;
use Illuminate\Database\Seeder;

class PasienSeeder extends Seeder
{
    public function run(): void
    {
        $pasiens = [
            ['no_rm' => 'RM-2024-001', 'nama' => 'Budi Santoso', 'tanggal_lahir' => '1990-05-15', 'jenis_kelamin' => 'L', 'alamat' => 'Jl. Merdeka No. 45, Jakarta', 'telepon' => '081234567896', 'email' => 'budi.santoso@email.com', 'golongan_darah' => 'A', 'status' => 'aktif'],
            ['no_rm' => 'RM-2024-002', 'nama' => 'Siti Aminah', 'tanggal_lahir' => '1985-08-20', 'jenis_kelamin' => 'P', 'alamat' => 'Jl. Sudirman No. 78, Jakarta', 'telepon' => '081234567897', 'email' => 'siti.aminah@email.com', 'golongan_darah' => 'B', 'status' => 'aktif'],
            ['no_rm' => 'RM-2024-003', 'nama' => 'Ahmad Yani', 'tanggal_lahir' => '1995-12-10', 'jenis_kelamin' => 'L', 'alamat' => 'Jl. Gatot Subroto No. 90, Jakarta', 'telepon' => '081234567898', 'email' => 'ahmad.yani@email.com', 'golongan_darah' => 'O', 'status' => 'aktif'],
            ['no_rm' => 'RM-2024-004', 'nama' => 'Dewi Sartika', 'tanggal_lahir' => '2000-03-25', 'jenis_kelamin' => 'P', 'alamat' => 'Jl. Diponegoro No. 12, Jakarta', 'telepon' => '081234567899', 'email' => 'dewi.sartika@email.com', 'golongan_darah' => 'AB', 'status' => 'aktif'],
            ['no_rm' => 'RM-2024-005', 'nama' => 'Rudi Hartono', 'tanggal_lahir' => '1988-07-18', 'jenis_kelamin' => 'L', 'alamat' => 'Jl. Thamrin No. 56, Jakarta', 'telepon' => '081234567900', 'email' => 'rudi.hartono@email.com', 'golongan_darah' => 'A', 'status' => 'aktif'],
            ['no_rm' => 'RM-2024-006', 'nama' => 'Lina Marlina', 'tanggal_lahir' => '1992-11-30', 'jenis_kelamin' => 'P', 'alamat' => 'Jl. Kuningan No. 23, Jakarta', 'telepon' => '081234567901', 'email' => 'lina.marlina@email.com', 'golongan_darah' => 'B', 'status' => 'aktif'],
            ['no_rm' => 'RM-2024-007', 'nama' => 'Hendra Gunawan', 'tanggal_lahir' => '1987-04-22', 'jenis_kelamin' => 'L', 'alamat' => 'Jl. Rasuna Said No. 67, Jakarta', 'telepon' => '081234567902', 'email' => 'hendra.gunawan@email.com', 'golongan_darah' => 'O', 'status' => 'aktif'],
            ['no_rm' => 'RM-2024-008', 'nama' => 'Maya Sari', 'tanggal_lahir' => '1998-09-14', 'jenis_kelamin' => 'P', 'alamat' => 'Jl. Senayan No. 89, Jakarta', 'telepon' => '081234567903', 'email' => 'maya.sari@email.com', 'golongan_darah' => 'AB', 'status' => 'aktif'],
            ['no_rm' => 'RM-2024-009', 'nama' => 'Agus Prasetyo', 'tanggal_lahir' => '1993-02-28', 'jenis_kelamin' => 'L', 'alamat' => 'Jl. Menteng No. 34, Jakarta', 'telepon' => '081234567904', 'email' => 'agus.prasetyo@email.com', 'golongan_darah' => 'A', 'status' => 'aktif'],
            ['no_rm' => 'RM-2024-010', 'nama' => 'Rina Wijaya', 'tanggal_lahir' => '1991-06-05', 'jenis_kelamin' => 'P', 'alamat' => 'Jl. Kemang No. 45, Jakarta', 'telepon' => '081234567905', 'email' => 'rina.wijaya@email.com', 'golongan_darah' => 'B', 'status' => 'aktif'],
            ['no_rm' => 'RM-2024-011', 'nama' => 'Joko Susilo', 'tanggal_lahir' => '1989-10-12', 'jenis_kelamin' => 'L', 'alamat' => 'Jl. Cikini No. 78, Jakarta', 'telepon' => '081234567906', 'email' => 'joko.susilo@email.com', 'golongan_darah' => 'O', 'status' => 'aktif'],
            ['no_rm' => 'RM-2024-012', 'nama' => 'Fitri Handayani', 'tanggal_lahir' => '1996-01-20', 'jenis_kelamin' => 'P', 'alamat' => 'Jl. Tebet No. 90, Jakarta', 'telepon' => '081234567907', 'email' => 'fitri.handayani@email.com', 'golongan_darah' => 'AB', 'status' => 'aktif'],
            ['no_rm' => 'RM-2024-013', 'nama' => 'Bambang Suryanto', 'tanggal_lahir' => '1984-08-08', 'jenis_kelamin' => 'L', 'alamat' => 'Jl. Pancoran No. 12, Jakarta', 'telepon' => '081234567908', 'email' => 'bambang.suryanto@email.com', 'golongan_darah' => 'A', 'status' => 'aktif'],
            ['no_rm' => 'RM-2024-014', 'nama' => 'Nurul Hidayah', 'tanggal_lahir' => '1997-12-15', 'jenis_kelamin' => 'P', 'alamat' => 'Jl. Pasar Minggu No. 56, Jakarta', 'telepon' => '081234567909', 'email' => 'nurul.hidayah@email.com', 'golongan_darah' => 'B', 'status' => 'aktif'],
            ['no_rm' => 'RM-2024-015', 'nama' => 'Eko Prasetyo', 'tanggal_lahir' => '1994-05-03', 'jenis_kelamin' => 'L', 'alamat' => 'Jl. Kalibata No. 23, Jakarta', 'telepon' => '081234567910', 'email' => 'eko.prasetyo@email.com', 'golongan_darah' => 'O', 'status' => 'aktif'],
        ];

        foreach ($pasiens as $pasien) {
            Pasien::create($pasien);
        }
    }
}
