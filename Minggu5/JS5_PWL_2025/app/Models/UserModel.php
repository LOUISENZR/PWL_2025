<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class UserModel extends Model
{
    use HasFactory;

    protected $table = 'm_user'; //Mendefinisikan nama tabel yang digunakan model 
    protected $primaryKey = 'id_user'; //Mendefinisikan primary key dari tabel yang digunakan
    /*
    * The atributes that are mass assiggnable.
    *
    * @var array
    */
    protected $fillable = ['level_id', 'username', 'nama', 'password'];

    public function level(): BelongsTo
    {
        return $this->belongsTo(LevelModel::class,'level_id', 'level_id');
    }

    
}