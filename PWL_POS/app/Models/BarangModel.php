<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangModel extends Model
{
    use HasFactory;
 
     protected $table = 'm_barang';
     protected $primaryKey = 'barang_id';
 
    protected $fillable = [
        'kategori_id', 
        'barang_kode',  // Sesuaikan dengan nama kolom di database
        'barang_nama',  // Sesuaikan dengan nama kolom di database
        'harga_beli', 
        'harga_jual'
    ];
 
     public function kategori()
     {
         return $this->belongsTo(KategoriModel::class, 'kategori_id', 'kategori_id');
     }
     protected $casts = [
        'harga_beli' => 'float',
        'harga_jual' => 'float',
    ];
}
