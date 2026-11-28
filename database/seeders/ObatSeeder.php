<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Obat;

class ObatSeeder extends Seeder
{
    public function run(): void
    {
        $obats = [
            ['kode_obat' => 'OBT001', 'nama_obat' => 'Paracetamol 500mg', 'kategori' => 'Analgesik', 'satuan' => 'tablet', 'stok' => 500, 'harga' => 500],
            ['kode_obat' => 'OBT002', 'nama_obat' => 'Amoxicillin 500mg', 'kategori' => 'Antibiotik', 'satuan' => 'kapsul', 'stok' => 300, 'harga' => 2000],
            ['kode_obat' => 'OBT003', 'nama_obat' => 'Ibuprofen 400mg', 'kategori' => 'Analgesik', 'satuan' => 'tablet', 'stok' => 400, 'harga' => 1500],
            ['kode_obat' => 'OBT004', 'nama_obat' => 'Cetirizine 10mg', 'kategori' => 'Antihistamin', 'satuan' => 'tablet', 'stok' => 250, 'harga' => 1000],
            ['kode_obat' => 'OBT005', 'nama_obat' => 'Omeprazole 20mg', 'kategori' => 'Antasida', 'satuan' => 'kapsul', 'stok' => 200, 'harga' => 3000],
            ['kode_obat' => 'OBT006', 'nama_obat' => 'Metformin 500mg', 'kategori' => 'Antidiabetes', 'satuan' => 'tablet', 'stok' => 350, 'harga' => 2500],
            ['kode_obat' => 'OBT007', 'nama_obat' => 'Amlodipine 5mg', 'kategori' => 'Antihipertensi', 'satuan' => 'tablet', 'stok' => 300, 'harga' => 2000],
            ['kode_obat' => 'OBT008', 'nama_obat' => 'Salbutamol Inhaler', 'kategori' => 'Bronkodilator', 'satuan' => 'inhaler', 'stok' => 100, 'harga' => 45000],
            ['kode_obat' => 'OBT009', 'nama_obat' => 'Vitamin C 1000mg', 'kategori' => 'Vitamin', 'satuan' => 'tablet', 'stok' => 600, 'harga' => 500],
            ['kode_obat' => 'OBT010', 'nama_obat' => 'Antasida Sirup', 'kategori' => 'Antasida', 'satuan' => 'botol', 'stok' => 150, 'harga' => 15000],
        ];

        foreach ($obats as $obat) {
            Obat::create($obat);
        }
    }
}
