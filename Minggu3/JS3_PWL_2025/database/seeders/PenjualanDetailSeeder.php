<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [];

        // Ambil semua penjualan_id yang valid dari tabel t_penjualan
        $penjualanIds = DB::table('t_penjualan')->pluck('penjualan_id')->toArray();

        if (empty($penjualanIds)) {
            echo "⚠ Tidak ada data di t_penjualan! Jalankan PenjualanSeeder dulu.";
            return;
        }

        // Loop untuk 10 transaksi penjualan, masing-masing memiliki 3 barang (total 30 data)
        foreach ($penjualanIds as $penjualanId) {
            for ($j = 1; $j <= 3; $j++) {
                $data[] = [
                    'penjualan_id' => $penjualanId,
                    'barang_id' => rand(1, 10), // Pastikan barang_id sesuai dengan tabel barang
                    'harga' => rand(5000, 500000),
                    'jumlah' => rand(1, 5),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Masukkan ke dalam tabel jika data tidak kosong
        if (!empty($data)) {
            DB::table('t_penjualan_detail')->insert($data);
            echo "✅ Seeder PenjualanDetailSeeder berhasil ditambahkan (30 data).";
        }
    }
}
