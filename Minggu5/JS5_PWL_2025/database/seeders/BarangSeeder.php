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
            ['barang_id' => 1, 'kategori_id' => 1, 'barang_kode' => 'ELK001', 'barang_nama' => 'Laptop', 'harga_beli' => 8000000, 'harga_jual' => 10000000],
            ['barang_id' => 2, 'kategori_id' => 1, 'barang_kode' => 'ELK002', 'barang_nama' => 'Smartphone', 'harga_beli' => 4000000, 'harga_jual' => 5000000],
            ['barang_id' => 3, 'kategori_id' => 2, 'barang_kode' => 'PKN001', 'barang_nama' => 'Kaos', 'harga_beli' => 75000, 'harga_jual' => 100000],
            ['barang_id' => 4, 'kategori_id' => 2, 'barang_kode' => 'PKN002', 'barang_nama' => 'Celana Jeans', 'harga_beli' => 150000, 'harga_jual' => 200000],
            ['barang_id' => 5, 'kategori_id' => 3, 'barang_kode' => 'MKN001', 'barang_nama' => 'Nasi Goreng', 'harga_beli' => 20000, 'harga_jual' => 25000],
            ['barang_id' => 6, 'kategori_id' => 3, 'barang_kode' => 'MKN002', 'barang_nama' => 'Roti', 'harga_beli' => 10000, 'harga_jual' => 15000],
            ['barang_id' => 7, 'kategori_id' => 4, 'barang_kode' => 'MNM001', 'barang_nama' => 'Teh Botol', 'harga_beli' => 4000, 'harga_jual' => 5000],
            ['barang_id' => 8, 'kategori_id' => 4, 'barang_kode' => 'MNM002', 'barang_nama' => 'Kopi', 'harga_beli' => 8000, 'harga_jual' => 10000],
            ['barang_id' => 9, 'kategori_id' => 5, 'barang_kode' => 'PRT001', 'barang_nama' => 'Kompor Gas', 'harga_beli' => 250000, 'harga_jual' => 300000],
            ['barang_id' => 10, 'kategori_id' => 5, 'barang_kode' => 'PRT002', 'barang_nama' => 'Setrika', 'harga_beli' => 150000, 'harga_jual' => 200000],
        ];
        
        DB::table('m_barang')->insert($data);
    }
}
