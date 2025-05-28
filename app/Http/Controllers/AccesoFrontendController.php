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
        


        return view('/acceso/show')->with(['acceso'=>$acceso]); 
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
    public function edit(acceso $access)
    {
        //listar marcas para llenar select
        $vuelos = vuelo::all();
        //mostrar vista update.blade.php junto al listado de vuelo
        view('acceso/update')->with(['acceso'=>$access,'vuelo'=>$vuelos]);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, acceso $access)
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
           'numero_vuelo'=> 'required'
        ]);
        //remplazar datos anteriosres por los nuevos
        $access->nombre =$data['nombre'];
        $access->tipo =$data['tipo'];
        $access->posicion =$data['posicion'];
        $access->ingreso =$data['ingreso'];
        $access->salida =$data['salida'];
        $access->Sincronizacion =$data['Sincronizacion'];
        $access->id =$data['id'];
        $access->objetos =$data['objetos'];
        $access->numero_vuelo =$data['numero_vuelo'];

        $access->update_at = now();

        // Enviar a guardar la actualizacion
        $access->save();

        //redireccionar

        return redirect('acceso/show');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Eliminar el producto con el id recibido

        acceso::destroy($id);

        //retornar una respuesta json

        return response()->json(array('res'=>true));
    }
}
