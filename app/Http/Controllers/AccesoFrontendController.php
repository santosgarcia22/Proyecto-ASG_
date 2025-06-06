<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\acceso;
use Carbon\Carbon;
use App\Models\vuelo;
use App\Models\Tipos;

class AccesoFrontendController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    // Traer todos los vuelos para el select
    $vuelos = vuelo::all();

    // Verifica si hay filtro de vuelo seleccionado
    $numeroVuelo = $request->input('numero_vuelo');

    $query = acceso::select(
            "acceso.numero_id",
            "acceso.nombre",
            "acceso.posicion",
            "acceso.ingreso",
            "acceso.salida",
            "acceso.Sicronizacion",
            "acceso.id",
            "acceso.objetos",
            "vuelo.numero_vuelo as numero_vuelo",
            "tipos.nombre_tipo as nombre_tipo"
        )
        ->join("vuelo", "vuelo.id_vuelo", "=", "acceso.vuelo")
        ->join("tipos", "tipos.id_tipo", "=", "acceso.tipo");

    // Si seleccionó un número de vuelo, filtra la consulta
    if (!empty($numeroVuelo)) {
        $query->where("vuelo.numero_vuelo", $numeroVuelo);
    }

    // Paginado
    $acceso = $query->paginate(5);

    return view('acceso.show')->with([
        'acceso' => $acceso,
        'vuelos' => $vuelos,
        'numeroVuelo' => $numeroVuelo
    ]);
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $vuelo = vuelo::all();
        $Tipos = Tipos::all();

        return view('/acceso/create')->with(['vuelo'=>$vuelo, 'Tipos'=>$Tipos]);
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
                'objetos' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'vuelo' => 'required',
            ],  [
                'objetos.mimes' => 'Solo se permiten imágenes en formato JPEG y PNG.',
                'objetos.max' => 'La imagen no debe superar los 2 MB.',
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

        $vuelo = vuelo::all();

        return view('/acceso/update')->with(['acceso' => $acceso, 'vuelo' => $vuelo]);
    }


    /**
     * Update the specified resource in storage.
     */
public function update(Request $request, acceso $acceso)
{
    $data = $request->validate([
        'nombre' => 'required',
        'tipo' => 'required',
        'posicion' => 'required',
        'ingreso' => 'required|date',
        'salida' => 'nullable|date',
        'Sicronizacion' => 'nullable|date',
        'id' => 'required',
        'vuelo' => 'required| integer',
        // Si actualizas archivo, valida archivos
        'objetos' => 'nullable|file|image|max:2048'
    ]);

    // Convertir fechas de datetime-local a formato MySQL
    $data['ingreso'] = Carbon::parse($data['ingreso'])->format('Y-m-d H:i:s');

    // Puede que salida y Sicronizacion sean opcionales
    $data['salida'] = $data['salida'] ? Carbon::parse($data['salida'])->format('Y-m-d H:i:s') : null;
    $data['Sicronizacion'] = $data['Sicronizacion'] ? Carbon::parse($data['Sicronizacion'])->format('Y-m-d H:i:s') : null;

    // Actualizar atributos
    $acceso->nombre = $data['nombre'];
    $acceso->tipo = $data['tipo'];
    $acceso->posicion = $data['posicion'];
    $acceso->ingreso = $data['ingreso'];
    $acceso->salida = $data['salida'];
    $acceso->Sicronizacion = $data['Sicronizacion'];
    $acceso->id = $data['id'];
    $acceso->vuelo = $data['vuelo'];

    // Manejo de archivo (si se sube)
    if ($request->hasFile('objetos')) {
        $file = $request->file('objetos');
        $filename = time().'_'.$file->getClientOriginalName();
        $file->storeAs('public/objetos', $filename);
        $acceso->objetos = 'objetos/'.$filename;
    }

    $acceso->updated_at = now();

    $acceso->save();

    return redirect()->route('admin.accesos.show');
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