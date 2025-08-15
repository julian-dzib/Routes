<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Choferes;
use Illuminate\Validation\ValidationException;

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
        //Capturar el error si ocurre
        try {
            //Validar los datos de entrada
            $request->validate([
                "NOMBRE" => "required|string|max:100",
                "TELEFONO" => [
                    'required',
                    "regex:/^(\+52)?\s?(1)?\s?[2-9]\d{1}\d{8}$/"
                ],
            ],[
                "NOMBRE.required" => "El campo nombre es obligatorio",
                "TELEFONO.required" => "El campo número de teléfono es obligatorio",
                "TELEFONO.regex" => "El número de teléfono no tiene un formato válido"
            ]
            );

            $drivers= new Choferes();
            $drivers->NOMBRE= $request->input('NOMBRE');
            $drivers->TELEFONO= $request->input('TELEFONO');
            $drivers->save();

            //Retornar un mensaje json en caso de que todo salieria bien
            return response()->json([
                'message' => 'El chofer ha sido creado',
                'data' => $drivers
            ], 201);

        }catch (ValidationException $e) {
        // Retornar el error de validacion
        return response()->json([
            'errors' => $e->errors()
        ], 422);

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
                "TELEFONO" => [
                    'required',
                    "regex:/^(\+52)?\s?(1)?\s?[2-9]\d{1}\d{8}$/"
                ],
            ],[
                "NOMBRE.required" => "El campo nombre es obligatorio",
                "NOMBRE.max" => "El campo nombre solo permite 100 caracteres",
                "TELEFONO.required" => "El campo número de teléfono es obligatorio",
                "TELEFONO.regex" => "El número de teléfono no tiene un formato válido"
            ]
            );

            $drivers->NOMBRE = $request->input('NOMBRE');
            $drivers->TELEFONO = $request->input('TELEFONO');
            $drivers->save();

            return response()->json([
                'message' => 'El chofer ha sido actualizado',
                'data' => $drivers
            ], 200);


        }catch (ValidationException $e) {
        return response()->json([
            'errors' => $e->errors()
        ], 422);

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
