<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\acceso;
use App\Models\vuelo;

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
           "vuelo.numero_vuelo as numero_vuelo"
        )->join("vuelo", "vuelo.id_vuelo", "=", "acceso.vuelo")->get();
        


            $acceso = acceso::paginate(5); // Puedes cambiar 10 por el número de registros por página
            return view('acceso.show')->with('acceso', $acceso);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $vuelo = vuelo::all();

        return view('/acceso/create')->with(['vuelo'=>$vuelo]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //validar campos
                $data = request()->validate([
                'nombre' => 'required',
                'tipo' => 'required',
                'posicion' => 'required',
                'ingreso' => 'required',
                'salida' => 'required',
                'Sicronizacion' => 'required',
                'id' => 'required',
                'objetos' => '|image|mimes:jpeg,png,jpg,gif|max:2048',
                'vuelo' => 'required',
            ]);
            // Guardar imagen en carpeta 'public/objetos'
                if ($request->hasFile('objetos')) {
                    $file = $request->file('objetos');
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $filePath = $file->storeAs('objetos', $filename, 'public');
                    $data['objetos'] = $filePath;
                }
        //enviar insert
        acceso::create($data);

        //Redireccionar

       return redirect()->route('admin.accesos.show');

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
   public function edit(acceso $acceso)
    {

        // $acceso = acceso::where('numero_id', $numero_id)->first();

        $vuelos = vuelo::all();
        return view('/acceso/update')->with(['acceso' => $acceso, 'vuelo' => $vuelos]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, acceso $acceso)
    {
        //validar campos
        $data = request()->validate([
           'nombre'=> 'required',
           'tipo'=> 'required',
           'posicion'=> 'required',
           'ingreso'=> 'required',
           'salida'=> 'required',
           'Sicronizacion'=> 'required',
           'id'=> 'required',
           'objetos'=> 'required',
           'vuelo'=> 'required'
        ]);
        //remplazar datos anteriosres por los nuevos
        $acceso->nombre =$data['nombre'];
        $acceso->tipo =$data['tipo'];
        $acceso->posicion =$data['posicion'];
        $acceso->ingreso =$data['ingreso'];
        $acceso->salida =$data['salida'];
        $acceso->Sicronizacion =$data['Sicronizacion'];
        $acceso->id =$data['id'];
        $acceso->objetos =$data['objetos'];
        $acceso->vuelo =$data['vuelo'];
        $acceso->update_at = now();
        // Enviar a guardar la actualizacion
        $acceso->save();
        //redireccionar
        return redirect('acceso/show');
    }

    /**
     * Remove the specified resource from storage.
     */
  public function destroy($id)
    {
        $registro = acceso::where('numero_id', $id)->first();

        if ($registro) {
            $registro->delete();
            return redirect()->route('admin.accesos.show')->with('mensaje', 'Registro eliminado exitosamente');
        }

        return redirect()->route('admin.accesos.show')->with('mensaje', 'No se encontró el registro');
    }

}
