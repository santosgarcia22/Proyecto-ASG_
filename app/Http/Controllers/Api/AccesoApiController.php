<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\acceso;

class AccesoApiController extends Controller
{
    //

    public function index()
    {
        return response()->json(acceso::all());
    }

    public function show($id)
    {
        $acceso = acceso::find($id);
        if ($acceso) {
            return response()->json($acceso);
        } else {
            return response()->json(['message' => 'Acceso no encontrado'], 404);
        }
    }


    public function store(Request $request)
    {
        $data = $request->all();

        // Por defecto, imagen dummy
        $data['objetos'] = 'default.jpg';

        // Si viene la imagen base64, la procesamos
        if ($request->has('imagen_base64')) {
            $imagen = $request->input('imagen_base64');
            $nombreArchivo = 'img_' . time() . '.jpg';
            $ruta = public_path('objetos/' . $nombreArchivo);
            file_put_contents($ruta, base64_decode($imagen));
            $data['objetos'] = 'objetos/' . $nombreArchivo; // Ruta relativa
            unset($data['imagen_base64']); // Eliminamos el base64 del array
        }

        // Asignar campos fijos o dummy si faltan
        $data['tipo'] = $request->tipo ?? 1;
        $data['posicion'] = $request->posicion ?? 'N/A';
        $data['ingreso'] = $request->ingreso ?? now();
        $data['salida'] = $request->salida ?? now();
        $data['Sicronizacion'] = $request->Sicronizacion ?? now();
        $data['id'] = $request->id ?? 'testAPI';
        $data['vuelo'] = $request->vuelo ?? 1;

        // Guardar registro
        $nuevo = acceso::create($data);

        return response()->json([
            'success' => true,
            'msg' => '¡Guardado!',
            'ruta' => $data['objetos'],
            'id' => $nuevo->numero_id
        ], 201);
    }


}