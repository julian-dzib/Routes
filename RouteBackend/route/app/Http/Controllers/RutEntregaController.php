<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PuntosEntrega;
class RutEntregaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
            "IDRUTAS" => "required|integer|exists:rutas,IDRUTAS",
            "DIRECCION" => "required|string",
            "ORDEN" => "required|integer",
            "ENTREGADO" => "boolean|required",
        ]);
        //Capturar el error si ocurre
        try {
            $stops= new PuntosEntrega();
            $stops->IDRUTAS= $request->input('IDRUTAS');
            $stops->DIRECCION= $request->input('DIRECCION');
            $stops->ORDEN= $request->input('ORDEN');
            $stops->ENTREGADO= $request->input('ENTREGADO');
            $stops->save();

            //Retornar un mensaje json
            return response()->json([
                'message' => 'Ha sido creado el punto de entrega',
                'data' => $stops
            ], 201);
        } catch (\Exception $e) {
            // Retornar un mensaje de error
            return response()->json([
                'error' => 'Error al crear el punto de entrega, verifique que los datos sean correctos'
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
    public function update(Request $request, string $id)
    {
        //
        try {
            $stops = PuntosEntrega::find($id);
            // Validar los datos de entrada nuevamene
            $request->validate([
            "IDRUTAS" => "required|integer|exists:rutas,IDRUTAS",
            "DIRECCION" => "required|string",
            "ORDEN" => "required|integer",
            "ENTREGADO" => "boolean|required",
            ]);

            $stops->IDRUTAS= $request->input('IDRUTAS');
            $stops->DIRECCION= $request->input('DIRECCION');
            $stops->ORDEN= $request->input('ORDEN');
            $stops->ENTREGADO= $request->input('ENTREGADO');
            $stops->save();
            return response()->json([
                'message' => 'El Punto de Entrega hd sido actualizado',
                'data' => $stops
            ], 200);
        }catch (\Exception $e) {
            // Retornar un mensaje de error
            return response()->json([
                'error' => 'Error al actualizar el punto de entrega, verifique que los datos sean correctos'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //Capturar el error si ocurre
        try {
            $stops = PuntosEntrega::find($id);
            if (!$stops) {
                return response()->json([
                    'error' => 'No se pudo eliminar el punto de entrega, porfavor verifque que exista'
                ], 404);
            }
            $stops->delete();
            return response()->json([
                'message' => 'El Punto de Entrega ha sido eliminado'
            ], 200);
        } catch (\Exception $e) {
            // Retornar un mensaje de error
            return response()->json([
                'error' => 'Error al eliminr el punto de entreaga'
            ], 500);
        }
    }
}
