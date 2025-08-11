<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Choferes;


class ChoferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        try {
            $drivers= Choferes::all();
            //Retornar un mensaje json
            return response()->json([
                'message' => 'Lista de choferes',
                'data' => $drivers
            ]);
        } catch (\Exception $e) {
            // Retornar un mensaje de error
            return response()->json([
                'error' => 'Error al obtener la lista de los choferes'
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
        //Validar los datos de entrada
        $request->validate([
            "NOMBRE" => "required|string|max:100",
            "TELEFONO" => "string",
        ]);
        //Capturar el error si ocurre
        try {
            $drivers= new Choferes();
            $drivers->NOMBRE= $request->input('NOMBRE');
            $drivers->TELEFONO= $request->input('TELEFONO');
            $drivers->save();

            //Retornar un mensaje json
            return response()->json([
                'message' => 'El chofer ha sido creado',
                'data' => $drivers
            ], 201);
        } catch (\Exception $e) {
            // Retornar un mensaje de error
            return response()->json([
                'error' => 'Error al crear el chofer'
            ], 500);
        }


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
    public function update(Request $request, $id)
    {
        //
        //Controlar el error si ocurre
        try {
            $drivers = Choferes::find($id);
            // Validar los datos de entrada nuevamene
            $request->validate([
                "NOMBRE" => "required|string|max:100",
                "TELEFONO" => "string",
            ]);

            $drivers->NOMBRE = $request->input('NOMBRE');
            $drivers->TELEFONO = $request->input('TELEFONO');
            $drivers->save();


        }catch (\Exception $e) {
            // Retornar un mensaje de error
            return response()->json([
                'error' => 'Error al actualizar el chofer, porfavor verifique que exista el registro'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //Capturar el error si ocurre
        try {
            $drivers = Choferes::find($id);
            if (!$drivers) {
                return response()->json([
                    'error' => 'No se pudo eliminar el chofer, porfavor verifque que exista'
                ], 404);
            }
            $drivers->delete();
            return response()->json([
                'message' => 'El chofer ha sido eliminado'
            ], 200);
        } catch (\Exception $e) {
            // Retornar un mensaje de error
            return response()->json([
                'error' => 'Error al eliminar el chofer, verfique de nuevo'
            ], 500);
        }
    }
}
