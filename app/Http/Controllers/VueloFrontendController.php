<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\vuelo;
use Carbon\Carbon;

class VueloFrontendController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

         $vuelo = vuelo::select(
           "vuelo.id_vuelo",
           "vuelo.fecha",
           "vuelo.numero_vuelo"
        )->get();
        
       return view('/vuelo/show')->with(['vuelo' => $vuelo]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
            //    $vuelo = vuelo::all();

        return view('/vuelo/create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //validar campos

        $data = request()->validate([
            'fecha'=>'required',
            'numero_vuelo'=>'required'
        ]);

        vuelo::create($data);
        
        //REDIRECCIONAR A LA VISTA SHOW

        return redirect()->route('admin.vuelo.show');

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
   public function edit(vuelo $vuelo)
    {
        return view('/vuelo/update', ['vuelo' => $vuelo]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, vuelo $vuelo)
    {
        //
        $data = $request->validate([
            'fecha' => 'required',
            'numero_vuelo' => 'required'
        ]);
        $data['fecha']= Carbon::parse($data['fecha'])->format('Y-m-d H:i:s');
        $vuelo->fecha = $data['fecha'];
        $vuelo->numero_vuelo = $data['numero_vuelo'];
        $vuelo->updated_at = now();
        $vuelo->save();
        return redirect()->route('admin.vuelo.show');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $registro = vuelo::where('id_vuelo', $id)->first();

        if ($registro) {
            $registro->delete();
            return redirect()->route('admin.vuelo.show')->with('mensaje', 'Registro eliminado exitosamente');
        }

        return redirect()->route('admin.vuelo.show')->with('mensaje', 'No se encontró el registro');
    }
}