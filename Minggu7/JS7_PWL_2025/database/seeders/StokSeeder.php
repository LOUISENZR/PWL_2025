<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;


class StokSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil semua barang dari tabel m_barang
        $barangs = DB::table('m_barang')->get();

        $stokData = [];

        foreach ($barangs as $barang) {
            // Simulasi jumlah stok (acak antara 10 sampai 100)
            $jumlah_stok = rand(10, 100);

            $data[] = [
                'barang_id'    => $barang->barang_id,
                'user_id'      => 1, // semua barang dimasukan oleh admin
                'stok_tanggal' => Carbon::now(),
                'stok_jumlah'  => $jumlah_stok,
                'created_at'   => Carbon::now(),
                'updated_at'   => Carbon::now(),
            ];
        }

        DB::table('t_stok')->insert($data);
    }
}
