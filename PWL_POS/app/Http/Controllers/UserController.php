<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModel;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $user = UserModel::with('level')->get();
        return view('user', ['data' => $user]);
        //dd($user);

        //$user = UserModel::create([
          //      'username' => 'admin_dua',
            //    'nama' => 'Admin2',
              //  'password' => Hash::make('12345'),
                //'level_id' => 1,
        //]);
        //$user->username = 'admin_tiga';

        //$user->isDirty(); //true
        //$user->isDirty('username'); //true
        //$user->isDirty('nama'); //false
        //$user->isDirty('nama', 'username'); //true
        
        //$user->isClean(); //false
        //$user->isClean('username'); //false
        //$user->isClean('nama'); //true
        //$user->isClean('nama', 'username'); //false

        //$user -> save();

        //$user->isDirty(); //false
        //$user->isClean(); //true
        //dd($user->isDirty());

        //$user = UserModel::firstOrNew(
          //  [
              //  'username' => 'manager',
            //    'nama' => 'Manager',
            //],
        //);

        //$user = UserModel::firstOrCreate(
            //[
                //'username' => 'manager_tiga',
                //'nama' => 'Manager3',
                //'password' => Hash::make('12345'),
                //'level_id' => 2
               //'username' => 'manager',
               //'nama' => 'Manager',
            //],
        //);
        //return view('user', ['data' => $user]);
        
        //$user = UserModel::where('level_id', 2) ->count();
        //dd($user); //eksekusi berhenti di dd() dan mengabaikan tampilan user.blade

        //$user = UserModel::where('username', 'manager9')->firstOrFail();

        //$user = UserModel::findOrFail(1);

        //$user = UserModel::findOr(20, ['username', 'nama'], function() {
        // aabort(404);
        //});

        //$user = UserModel::findOr(1, ['username', 'nama'], function() {
            //abort(404);
        //});

        //$user = UserModel::firstWhere('level_id', 1);

        //$user = UserModel::where('level_id', 1)->first();

        //$user = UserModel::find(1);
        //return view('user', ['data' => $user]);

        //$data =[
                //'level_id' => 2,
                //'username' => 'manager_dua',
                //'nama' => 'Manager2',
                //'password' => Hash::make('12345')
        //];
        //UserModel::create($data);

        // tambah data user dengan Eloquent Model
        //$data = [
            //'nama' => 'Pelanggan Pertama',
        //];
        //UserModel::where('username', 'Customer1')->update($data);//update data user

        //coba akses model UserModel
        $user = UserModel::all(); // ambil semua data dari tabel m_user
        return view('user', ['data' => $user]);
    }
    public function tambah(){
        return view('user_tambah');
    }
    public function tambah_simpan(Request $request){
        UserModel::create([
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => Hash::make('$request->password'),
            'level_id' => $request->level_id
        ]);
        return redirect('/user');   
    }
    public function ubah($id){
        $user = UserModel::find($id);
        return view('user_ubah', ['data' => $user]);
    }
    public function ubah_simpan($id, Request $request){
        $user = UserModel::find($id);

        $user->username = $request->username;
        $user->nama = $request->nama;
        $user->password = Hash::make('$request->password');
        $user->level_id = $request->level_id;

        $user->save();
        return redirect('/user');
    }
    public function hapus($id){
        $user = UserModel::find($id);
        $user->delete();

        return redirect('/user');
    }
}