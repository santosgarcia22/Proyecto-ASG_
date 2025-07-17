<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UsuarioApp;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class UsuarioAppController extends Controller
{
    //

    // Muestra la vista principal
  public function index() {
        $usuarios = UsuarioApp::all();
        return view('usuariosapp.index', compact('usuarios'));
    }


     // Carga AJAX de tabla
    public function tabla() {
        $usuarios = UsuarioApp::all();
        dd($usuarios); // Debería salir una colección de usuarios
        // $usuarios = UsuariosApp::orderBy('id_usuario', 'asc')->get();
        // return view('backend.admin.usuariosapp.tabla', compact('usuarios'));
        return view('backend.usuariosapp.tabla', compact('usuarios'));
    }

     // Guardar nuevo usuario
    public function nuevo(Request $request) {
        $validator = Validator::make($request->all(), [
            'usuario' => 'required|string|max:50|unique:usuariosapp,usuario',
            'email' => 'required|email|max:100|unique:usuariosapp,email',
            'password' => 'required|string|min:4|max:16',
            'nombre_completo' => 'required|string|max:100'
        ]);
        if ($validator->fails()) {
            return ['success' => 0];
        }

        $usuario = new UsuariosApp();
        $usuario->usuario = $request->usuario;
        $usuario->email = $request->email;
        $usuario->nombre_completo = $request->nombre_completo;
        $usuario->activo = 1;
        $usuario->password = Hash::make($request->password); // Guarda hash

        $usuario->save();

        return ['success' => 2];
    }

    // Traer info de un usuario (editar)
    public function info(Request $request) {
        $usuario = UsuariosApp::find($request->id);
        if (!$usuario) {
            return ['success' => 0];
        }
        return ['success' => 1, 'usuario' => $usuario];
    }

    // Editar usuario
    public function editar(Request $request) {
        $usuario = UsuariosApp::find($request->id_usuario);
        if (!$usuario) {
            return ['success' => 0];
        }

        // Validar email/usuario únicos (menos el actual)
        $validator = Validator::make($request->all(), [
            'usuario' => 'required|string|max:50|unique:usuariosapp,usuario,'.$usuario->id_usuario.',id_usuario',
            'email' => 'required|email|max:100|unique:usuariosapp,email,'.$usuario->id_usuario.',id_usuario',
            'nombre_completo' => 'required|string|max:100'
        ]);
        if ($validator->fails()) {
            return ['success' => 0];
        }

        $usuario->usuario = $request->usuario;
        $usuario->email = $request->email;
        $usuario->nombre_completo = $request->nombre_completo;
        $usuario->activo = $request->activo ? 1 : 0;

        // Cambiar password solo si la llenaron
        if($request->password){
            $usuario->password = Hash::make($request->password);
        }

        $usuario->save();

        return ['success' => 2];
    }


}