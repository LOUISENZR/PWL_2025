<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        return 'Nama: Louise Nazarossa <br> NIM: 2341760117';
    }
}