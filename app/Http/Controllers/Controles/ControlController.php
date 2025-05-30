<?php

namespace App\Http\Controllers\Controles;

use App\Http\Controllers\Controller;
use App\Models\P_Departamento;
use App\Models\P_UsuarioDepartamento;
use Illuminate\Support\Facades\Auth;

class ControlController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function indexRedireccionamiento(){

        $user = Auth::user();

        // ADMINISTRADOR SISTEMA
        if($user->hasRole('admin')){
            $ruta = 'admin.home';
        }
        else if($user->hasRole('usuario')){
            $ruta = 'admin.dashboard.index';
        }
        else{
            // no tiene ningun permiso de vista, redirigir a pantalla sin permisos
            $ruta = 'no.permisos.index';
        }

        $titulo = "Proyecto ASG AIRSECURITY";

        return view('backend.index', compact( 'ruta', 'user', 'titulo'));
    }

    public function home()
    {

         $user = Auth::user();
         if($user->hasRole('admin')){
            $ruta = 'admin.roles.index';
        }
        else if($user->hasRole('usuario')){
            $ruta = 'admin.dashboard.index';
        }
        else{
            // no tiene ningun permiso de vista, redirigir a pantalla sin permisos
            $ruta = 'no.permisos.index';
        }

        // Puedes pasar datos reales desde la BD si lo deseas
        $totalUsuarios = 2; // User::count();
        $accesosHoy = 3;     // Acceso::whereDate('ingreso', today())->count();
        $totalVuelos = 0;     // Vuelo::count();
        $alertas = 0;         // Alertas activas

        // Ejemplo para gráfico:
        $dias = ['Lun','Mar','Mié','Jue','Vie','Sáb','Dom'];
        $accesosPorDia = [12, 15, 9, 18, 10, 17, 11]; // Simulado

        // Últimos accesos recientes (consulta real)
        $accesosRecientes = []; // Acceso::latest()->take(10)->get();

       return view('backend.admin.home.home', compact(
            'totalUsuarios', 'accesosHoy', 'totalVuelos', 'alertas',
            'dias', 'accesosPorDia', 'accesosRecientes'
        ));
    }

    // redirecciona a vista sin permisos
    public function indexSinPermiso(){
        return view('errors.403');
    }

}