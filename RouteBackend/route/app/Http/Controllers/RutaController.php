<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rutas;
use Route;
class RutaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        try {
            //$routes= Rutas::all();
            //Con base a la relaccion devuelvo los datos del chofer
            $routes=Rutas::with('chofer')->get();
            //Retornar un mensaje json
            return response()->json([
                'message' => 'Lista de rutas disponiblesq',
                'data' => $routes
            ]);
        } catch (\Exception $e) {
            // Retornar un mensaje de error
            return response()->json([
                'error' => 'Error al obtener las rutas'
            ], 500);
        }
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
        //Validar los datos de entrada
        $request->validate([
            "NOMBRE" => "required|string|max:100",
            "FECHA" => "date",
            "IDCHOFER" => "required|integer|exists:choferes,IDCHOFER",
        ]);
        //Capturar el error si ocurre
        try {
            $routes= new Rutas();
            $routes->NOMBRE= $request->input('NOMBRE');
            $routes->FECHA= $request->input('FECHA');
            $routes->IDCHOFER= $request->input('IDCHOFER');
            $routes->save();

            //Retornar un mensaje json
            return response()->json([
                'message' => 'El RUTA ha sido creado',
                'data' => $routes
            ], 201);
        } catch (\Exception $e) {
            // Retornar un mensaje de error
            return response()->json([
                'error' => 'Error al crear el ruta, verifique que los datos sean correctos'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //Buscar una ruta por ID
        //Traer el elemento especifico
        $routes = Rutas::where('IDRUTAS', $id)->first();

        if (!$routes) {
            return response()->json([
                'error' => 'La ruta no fue encontrada, verifique que la ruta exista'
            ], 404);
        }

        return response()->json([
            'message' => 'Ruta Encontrada',
            'data' => $routes
        ]);
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
    public function update(Request $request, $id)
    {
        //
        try {
            $routes = Rutas::find($id);
            // Validar los datos de entrada nuevamene
            $request->validate([
            "NOMBRE" => "required|string|max:100",
            "FECHA" => "date",
            "IDCHOFER" => "required|integer|exists:choferes,IDCHOFER",
            ]);

            $routes->NOMBRE= $request->input('NOMBRE');
            $routes->FECHA= $request->input('FECHA');
            $routes->IDCHOFER= $request->input('IDCHOFER');
            $routes->save();
            return response()->json([
                'message' => 'La Ruta Ha sido actualizada',
                'data' => $routes
            ], 200);
        }catch (\Exception $e) {
            // Retornar un mensaje de error
            return response()->json([
                'error' => 'Error al actualizar la ruta, porfavor verifique que exista la ruta'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        //Capturar el error si ocurre
        try {
            $routes = Rutas::find($id);
            if (!$routes) {
                return response()->json([
                    'error' => 'No se pudo eliminar la ruta, porfavor verifque que exista'
                ], 404);
            }
            $routes->delete();
            return response()->json([
                'message' => 'La ruta ha sido eliminado'
            ], 200);
        } catch (\Exception $e) {
            // Retornar un mensaje de error
            return response()->json([
                'error' => 'Error al eliminar la ruta, verfique de nuevo'
            ], 500);
        }
    }
}
