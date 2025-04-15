<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Penjualan_detailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // mengambilpenjualan yang sudah ada di tabel t_penjualan
        $penjualans = DB::table('t_penjualan')->get();

        // mengambil barang dari tabel m_barang
        $barangs = DB::table('m_barang')->get();

        $data = [];

        // detail penjualan
        foreach ($penjualans as $penjualan) {
            // Menentukan jumlah detail untuk penjualan
            $detailCount = rand(1, 3);
            for ($i = 0; $i < $detailCount; $i++) {
                // Pilih satu barang secara random
                $barang = $barangs->random();

                // Ambil harga jual dari barang sebagai harga untuk detail penjualan
                $harga = $barang->harga_jual;
                // Tentukan jumlah barang yang terjual secara acak
                $jumlah = rand(1, 5);

                $data[] = [
                    'penjualan_id' => $penjualan->penjualan_id,
                    'barang_id'    => $barang->barang_id,
                    'harga'        => $harga,
                    'jumlah'       => $jumlah,
                    'created_at'   => Carbon::now(),
                    'updated_at'   => Carbon::now(),
                ];
            }
        }

        // Lakukan insert ke tabel t_penjualan_detail
        DB::table('t_penjualan_detail')->insert($data);
    }
}
