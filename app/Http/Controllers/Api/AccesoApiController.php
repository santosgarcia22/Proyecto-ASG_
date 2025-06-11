<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Acceso;

class AccesoApiController extends Controller
{
    //

    public function index()
    {
        return response()->json(Acceso::all());
    }

    public function show($id)
    {
        $acceso = Acceso::find($id);
        if ($acceso) {
            return response()->json($acceso);
        } else {
            return response()->json(['message' => 'Acceso no encontrado'], 404);
        }
    }

    public function store(Request $request)
    {
        $nuevo = Acceso::create($request->all());
        return response()->json($nuevo, 201);
    }
}
