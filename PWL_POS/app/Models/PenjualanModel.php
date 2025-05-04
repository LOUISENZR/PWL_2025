<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenjualanModel extends Model
{
    use HasFactory;

    protected $table = 't_penjualan'; // Menyebutkan nama tabel

    protected $primaryKey = 'penjualan_id'; // Menyebutkan primary key

    public $timestamps = true; // Menandakan bahwa tabel ini menggunakan created_at dan updated_at

    // Mendefinisikan kolom yang dapat diisi (fillable)
    protected $fillable = [
        'user_id',
        'pembeli',
        'penjualan_kode',
        'penjualan_tanggal',
    ];

    // Relasi dengan tabel User (Jika penjualan terkait dengan pengguna)
    public function user()
    {
        return $this->belongsTo(UserModel::class, 'user_id', 'user_id');
    }

    // Relasi dengan Barang (Jika banyak barang terkait dengan penjualan tertentu)
    public function barang()
    {
        // Misalkan transaksi penjualan melibatkan beberapa barang dalam satu transaksi
        return $this->belongsToMany(BarangModel::class, 't_penjualan_barang', 'penjualan_id', 'barang_id')
                    ->withPivot('jumlah', 'harga');
    }

    // Aksesori untuk memformat tanggal penjualan
    public function getPenjualanTanggalAttribute($value)
    {
        return date('d-m-Y', strtotime($value));
    }

    // Aksesori untuk mendapatkan total harga dari penjualan (jumlah * harga)
    public function getTotalPenjualanAttribute()
    {
        $total = 0;
        foreach ($this->barang as $item) {
            $total += $item->pivot->jumlah * $item->pivot->harga;
        }
        return number_format($total, 0, ',', '.'); // Mengembalikan dalam format currency
    }

    // Scope untuk pencarian penjualan berdasarkan kode
    public function scopeSearchByKode($query, $kode)
    {
        if ($kode) {
            return $query->where('penjualan_kode', 'like', "%$kode%");
        }
        return $query;
    }

    // Method untuk menampilkan data penjualan secara ringkas (misalnya untuk daftar)
    public function getRingkasPenjualanAttribute()
    {
        return strtoupper($this->penjualan_kode) . ' - ' . ucfirst($this->pembeli);
    }

    // Method untuk mendapatkan format tanggal penjualan yang lebih mudah dibaca
    public function getFormattedPenjualanTanggalAttribute()
    {
        return \Carbon\Carbon::parse($this->penjualan_tanggal)->format('l, d F Y');
    }
}
