<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [];
        
        // nama pembeli
        $namaPembeli = [
            'John Doe',
            'Jane Smith',
            'Alice Johnson',
            'Bob Williams',
            'Charlie Brown',
            'Diana Prince',
            'Edward Norton',
            'Fiona Apple',
            'George Clooney',
            'Hannah Montana',
            'Ivan Drago',
            'Julia Roberts'
        ];
        
        // membuat 12 penjualan
        for ($i = 0; $i < 12; $i++) {
            // user_id 3 dan 4 yang melayani penjualan
            $userId = ($i % 2 === 0) ? 3 : 4;
            
            // Format kode penjualan
            $kode = 'PNJ' . str_pad($i + 1, 4, '0', STR_PAD_LEFT);
            
            // Set tanggal penjualan
            $tanggal = Carbon::now()->subDays($i);
            
            $data[] = [
                'user_id'            => $userId,
                'pembeli'            => $namaPembeli[$i],
                'penjualan_kode'     => $kode,
                'penjualan_tanggal'  => $tanggal,
                'created_at'         => Carbon::now(),
                'updated_at'         => Carbon::now(),
            ];
        }
        
        DB::table('t_penjualan')->insert($data);
    }
}
