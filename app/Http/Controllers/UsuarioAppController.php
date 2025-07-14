<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UsuarioApp;

class UsuarioAppController extends Controller
{
    //

    public function index()
    {
        $usuarios = UsuarioApp::paginate(10);

        return view('/usuariosapp.index', compact('usuarios'));
    }
}
