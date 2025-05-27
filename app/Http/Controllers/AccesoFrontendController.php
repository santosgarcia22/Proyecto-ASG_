<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\acceso;

class AccesoFrontendController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

        $acceso = acceso::select(
           "acceso.numero_id",
           "acceso.nombre",
           "acceso.tipo",
           "acceso.posicion",
           "acceso.ingreso",
           "acceso.salida",
           "acceso.Sicronizacion",
           "acceso.id",
           "acceso.objetos",
           "vuelo.fecha as vuelo"
        )->join("vuelo", "vuelo.id_vuelo", "=", "acceso.vuelo")->get();
        
        return view('/acceso/show')->with(['acceso'=>$acceso]); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
