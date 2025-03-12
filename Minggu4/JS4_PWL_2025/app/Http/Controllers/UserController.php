<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModel;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $user = UserModel::all();
        return view('user', ['data' => $user]);
    }
    public function tambah(){
        return view('user_tambah');
    }
}
        //$user = UserModel::find(1);
        

        //$user = UserModel::where('level_id', 1)->first();
        
        //$user = UserModel::firstWhere('level_id', 1);

        //$user = UserModel::findOr(1, ['username', 'nama'], function() {
        // abort(404);
        //});
        
        //$user = UserModel::findOr(20, ['username', 'nama'], function() {
        // aabort(404);
        //});

        //$user = UserModel::findOrFail(1);

        //$user = UserModel::where('username', 'manager9')->firstOrFail();
        
        //$user = UserModel::where('level_id', 2) ->count();
        //dd($user); //eksekusi berhenti di dd() dan mengabaikan tampilan user.blade

        //$user = UserModel::firstOrCreate(
           // [
               //'username' => 'manager22',
               //'nama' => 'Manager Dua Dua',
                //'password' => Hash::make('12345'),
                //'level_id' => 2
            //],
        //);

        //$user = UserModel::firstOrNew(
            //[
                //'username' => 'manager11',
                //'nama' => 'Manager11',
                //'password' => Hash::make('12345'),
                //'level_id' => 2
            //],
        //);
       // $user->username = 'manager12';
        
        //$user->save();

        //$user->isDirty(); //true
        //$user->isDirty('username'); //true
        //$user->isDirty('nama'); //false
        //$user->isDirty('nama', 'username'); //true
        
        //$user->isClean(); //false
        //$user->isClean('username'); //false
        //$user->isClean('nama'); //true
        //$user->isClean('nama', 'username'); //false

        //$user->isDirty(); //false
        //$user->isClean(); //true
        //$user->wasChanged(); //true
        //$user->wasChanged('username'); //true
        //$user->wasChanged(['username', 'level_id']); //true
        //$user->wasChanged('nama'); //false
        //dd($user->wasChanged(['nama', 'username'])); //true

    
