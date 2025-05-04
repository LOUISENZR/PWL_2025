<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            // Elektronik (ELK)
            [
                'kategori_id' => 1,
                'barang_kode' => 'ELK001',
                'barang_nama' => 'TV LED',
                'harga_beli' => 2500000,
                'harga_jual' => 3200000,
            ],
            [
                'kategori_id' => 1,
                'barang_kode' => 'ELK002',
                'barang_nama' => 'Smartphone Android',
                'harga_beli' => 1800000,
                'harga_jual' => 2300000,
            ],
            [
                'kategori_id' => 1,
                'barang_kode' => 'ELK003',
                'barang_nama' => 'Laptop',
                'harga_beli' => 6500000,
                'harga_jual' => 7800000,
            ],

            // Pakaian (PKN)
            [
                'kategori_id' => 2,
                'barang_kode' => 'PKN001',
                'barang_nama' => 'Kaos Polos',
                'harga_beli' => 50000,
                'harga_jual' => 85000,
            ],
            [
                'kategori_id' => 2,
                'barang_kode' => 'PKN002',
                'barang_nama' => 'Celana Jeans',
                'harga_beli' => 120000,
                'harga_jual' => 180000,
            ],

            // Makanan (MKN)
            [
                'kategori_id' => 3,
                'barang_kode' => 'MKN001',
                'barang_nama' => 'Nasi Kotak',
                'harga_beli' => 15000,
                'harga_jual' => 25000,
            ],
            [
                'kategori_id' => 3,
                'barang_kode' => 'MKN002',
                'barang_nama' => 'Ayam Goreng',
                'harga_beli' => 12000,
                'harga_jual' => 20000,
            ],

            // Minuman (MNM)
            [
                'kategori_id' => 4,
                'barang_kode' => 'MNM001',
                'barang_nama' => 'Air Mineral',
                'harga_beli' => 3000,
                'harga_jual' => 5000,
            ],
            [
                'kategori_id' => 4,
                'barang_kode' => 'MNM002',
                'barang_nama' => 'Jus Jeruk Segar',
                'harga_beli' => 8000,
                'harga_jual' => 12000,
            ],

            // Peralatan Rumah Tangga (PRT)
            [
                'kategori_id' => 5,
                'barang_kode' => 'PRT001',
                'barang_nama' => 'Panci Stainless',
                'harga_beli' => 95000,
                'harga_jual' => 125000,
            ],
            [
                'kategori_id' => 5,
                'barang_kode' => 'PRT002',
                'barang_nama' => 'Wajan Teflon',
                'harga_beli' => 75000,
                'harga_jual' => 110000,
            ],

            // Alat Tulis Kerja (ATK)
            [
                'kategori_id' => 6,
                'barang_kode' => 'ATK001',
                'barang_nama' => 'Buku Tulis',
                'harga_beli' => 5000,
                'harga_jual' => 8000,
            ],
            [
                'kategori_id' => 6,
                'barang_kode' => 'ATK002',
                'barang_nama' => 'Pulpen Standard',
                'harga_beli' => 3000,
                'harga_jual' => 5000,
            ],

            // Cemilan (CML)
            [
                'kategori_id' => 7,
                'barang_kode' => 'CML001',
                'barang_nama' => 'Keripik Kentang',
                'harga_beli' => 8000,
                'harga_jual' => 12000,
            ],
            [
                'kategori_id' => 7,
                'barang_kode' => 'CML002',
                'barang_nama' => 'Kacang Almond',
                'harga_beli' => 15000,
                'harga_jual' => 22000,
            ],
        ];
        DB::table('m_barang')->insert($data);

    }
}
