<?php

namespace App\Models;

use App\Http\Middleware\Authenticate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable; //implementasi class authticatable

class UserModel extends Authenticatable
{
    use HasFactory;

    protected $table = 'm_user'; //Mendefinisikan nama tabel yang digunakan model 
    protected $primaryKey = 'id_user'; //Mendefinisikan primary key dari tabel yang digunakan
    
    protected $fillable = ['username', 'password', 'nama', 'level_id', 'create_at', 'update_at'];
    protected $hidden = ['password']; //jangan di tampilkan saat select
    protected $casts = ['password'=> 'hashed']; //casting password agar otomatis di hash
    
    public function level(): BelongsTo
    {
        return $this->belongsTo(LevelModel::class,'level_id', 'level_id');
    }

    public function getRoleName (){
        return $this->level->level_nama;
    }
 
    public function hasRole ($role) : bool{
        return $this->level->level_kode == $role;
    }

    public function getRole(){
        return $this->level->level_kode;
    }
}