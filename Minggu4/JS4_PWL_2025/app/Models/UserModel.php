<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    use HasFactory;

    protected $table = 'm_user'; //Mendefinisikan nama tabel yang digunakan model 
    protected $primarykey = 'id_user'; //Mendefinisikan primary key dari tabel yang digunakan
    /*
    * The atributes that are mass assiggnable.
    *
    *@var array
    */
    protected $fillable = ['level_id', 'username', 'nama'];
}