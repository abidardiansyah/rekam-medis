<?php

namespace Database\Seeders;

use App\Models\Apotek;
use Illuminate\Database\Seeder;

class ApotekSeeder extends Seeder
{
    public function run(): void
    {
        $obats = [
            ['kode_obat' => 'OBT-001', 'nama_obat' => 'Paracetamol 500mg', 'kategori' => 'Analgesik', 'satuan' => 'Tablet', 'stok' => 500, 'harga' => 500, 'tanggal_kadaluarsa' => '2025-12-31', 'deskripsi' => 'Obat pereda nyeri dan demam', 'status' => 'tersedia'],
            ['kode_obat' => 'OBT-002', 'nama_obat' => 'Amoxicillin 500mg', 'kategori' => 'Antibiotik', 'satuan' => 'Kapsul', 'stok' => 300, 'harga' => 2000, 'tanggal_kadaluarsa' => '2025-10-15', 'deskripsi' => 'Antibiotik untuk infeksi bakteri', 'status' => 'tersedia'],
            ['kode_obat' => 'OBT-003', 'nama_obat' => 'Omeprazole 20mg', 'kategori' => 'Antasida', 'satuan' => 'Kapsul', 'stok' => 200, 'harga' => 3500, 'tanggal_kadaluarsa' => '2026-03-20', 'deskripsi' => 'Obat maag dan asam lambung', 'status' => 'tersedia'],
            ['kode_obat' => 'OBT-004', 'nama_obat' => 'Ibuprofen 400mg', 'kategori' => 'Analgesik', 'satuan' => 'Tablet', 'stok' => 400, 'harga' => 1500, 'tanggal_kadaluarsa' => '2025-08-30', 'deskripsi' => 'Anti inflamasi dan pereda nyeri', 'status' => 'tersedia'],
            ['kode_obat' => 'OBT-005', 'nama_obat' => 'Cetirizine 10mg', 'kategori' => 'Antihistamin', 'satuan' => 'Tablet', 'stok' => 250, 'harga' => 1000, 'tanggal_kadaluarsa' => '2026-01-15', 'deskripsi' => 'Obat alergi', 'status' => 'tersedia'],
            ['kode_obat' => 'OBT-006', 'nama_obat' => 'Metformin 500mg', 'kategori' => 'Antidiabetes', 'satuan' => 'Tablet', 'stok' => 350, 'harga' => 2500, 'tanggal_kadaluarsa' => '2025-11-20', 'deskripsi' => 'Obat diabetes tipe 2', 'status' => 'tersedia'],
            ['kode_obat' => 'OBT-007', 'nama_obat' => 'Amlodipine 5mg', 'kategori' => 'Antihipertensi', 'satuan' => 'Tablet', 'stok' => 300, 'harga' => 3000, 'tanggal_kadaluarsa' => '2026-02-28', 'deskripsi' => 'Obat tekanan darah tinggi', 'status' => 'tersedia'],
            ['kode_obat' => 'OBT-008', 'nama_obat' => 'Salbutamol Inhaler', 'kategori' => 'Bronkodilator', 'satuan' => 'Inhaler', 'stok' => 100, 'harga' => 45000, 'tanggal_kadaluarsa' => '2025-09-10', 'deskripsi' => 'Obat asma', 'status' => 'tersedia'],
            ['kode_obat' => 'OBT-009', 'nama_obat' => 'Vitamin C 1000mg', 'kategori' => 'Vitamin', 'satuan' => 'Tablet', 'stok' => 600, 'harga' => 800, 'tanggal_kadaluarsa' => '2026-06-30', 'deskripsi' => 'Suplemen vitamin C', 'status' => 'tersedia'],
            ['kode_obat' => 'OBT-010', 'nama_obat' => 'Antasida Sirup', 'kategori' => 'Antasida', 'satuan' => 'Botol', 'stok' => 150, 'harga' => 15000, 'tanggal_kadaluarsa' => '2025-07-15', 'deskripsi' => 'Obat maag cair', 'status' => 'tersedia'],
            ['kode_obat' => 'OBT-011', 'nama_obat' => 'Loperamide 2mg', 'kategori' => 'Antidiare', 'satuan' => 'Kapsul', 'stok' => 0, 'harga' => 1200, 'tanggal_kadaluarsa' => '2025-12-01', 'deskripsi' => 'Obat diare', 'status' => 'habis'],
            ['kode_obat' => 'OBT-012', 'nama_obat' => 'Dexamethasone 0.5mg', 'kategori' => 'Kortikosteroid', 'satuan' => 'Tablet', 'stok' => 180, 'harga' => 2000, 'tanggal_kadaluarsa' => '2026-04-10', 'deskripsi' => 'Anti inflamasi', 'status' => 'tersedia'],
        ];

        foreach ($obats as $obat) {
            Apotek::create($obat);
        }
    }
}
