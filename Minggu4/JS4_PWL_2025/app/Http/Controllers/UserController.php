<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModel;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
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
        
        $user = UserModel::where('level_id', 2) ->count();
        //dd($user); //eksekusi berhenti di dd() dan mengabaikan tampilan user.blade
        return view('user', ['data' => $user]);

    }
}