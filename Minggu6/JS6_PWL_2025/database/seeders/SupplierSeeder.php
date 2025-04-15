<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_supplier')->insert([
            [
                'supplier_kode' => 'SUP001',
                'supplier_nama' => 'CV Sumber Jaya',
                'supplier_alamat' => 'Jl. Mawar No. 45, Jakarta',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'supplier_kode' => 'SUP002',
                'supplier_nama' => 'PT Berkah Makmur',
                'supplier_alamat' => 'Jl. Melati No. 12, Bandung',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'supplier_kode' => 'SUP003',
                'supplier_nama' => 'UD Amanah',
                'supplier_alamat' => 'Jl. Kenanga No. 88, Surabaya',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    
    }
}
