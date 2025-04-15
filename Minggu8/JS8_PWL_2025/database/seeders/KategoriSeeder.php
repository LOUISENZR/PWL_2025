<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['kategori_id' => 1, 'kategori_kode' => 'ELK', 'kategori_nama' => 'Elektronik'],
            ['kategori_id' => 2, 'kategori_kode' => 'PKN', 'kategori_nama' => 'Pakaian'],
            ['kategori_id' => 3, 'kategori_kode' => 'MKN', 'kategori_nama' => 'Makanan'],
            ['kategori_id' => 4, 'kategori_kode' => 'MNM', 'kategori_nama' => 'Minuman'],
            ['kategori_id' => 5, 'kategori_kode' => 'PRT', 'kategori_nama' => 'Peralatan Rumah Tangga'],
            ['kategori_id' => 6, 'kategori_kode' => 'ATK', 'kategori_nama' => 'Alat Tulis Kerja'],
            ['kategori_id' => 7, 'kategori_kode' => 'CML', 'kategori_nama' => 'Cemilan'],
        ];
        DB::table('m_kategori')->insert($data);
    }
}
