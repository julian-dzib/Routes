<?php

namespace App\Http\Controllers;

//use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rules\Password;


class AuthController extends Controller
{
    //
    //Metodo para registrar un usuario
    public function register(Request $request){
        try {

            //Validar los campos
            $data = $request->validate( [
                'name'=> 'required|string|max:255|regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s\-]+$/',
                'email' => 'required|string|email|max:255|unique:users|regex:/^[\w\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z]{2,6}$/',
                'password'=> ['required','string',Password::min(10)],
            ],[
                'name.required'=> 'El campo nombre es obligatorio',
                'email.required'=> 'El campo correo es obligatorio',
                'password.required'=> 'El campo contraseña es obligatorio',

                'name.max'=> 'El campo nombre solo acepta un máximo de 255 caracteres',
                'name.regex'=> 'El campo nombre no debe llevar numeros',

                'email.regex'=> 'El correo no tiene un formato valido',
                'email.unique'=> 'El correo ya tiene una cuenta asociada',
                'password.min'=> 'La contraseña debe tener al menos 10 caracteres',
            ]


            );
            //Crear el usuario
            $user = User::create([
                'name'=> $data['name'],
                'email'=> $data['email'],
                'password'=> Hash::make($data['password']),
            ]);

            //Generar el token de acceso
            $token = $user->createToken('clientSecret')->accessToken;

            //Retornamos el usuario con su token de acceso
            return response()->json([
                'message' => 'User registrado exitosamente',
                'user' => $user,
                'token'=> $token,
            ]);
        } catch (ValidationException $e) {
            return response()->json([
            'errors' => $e->errors()
            ], 422);
        }catch (\Exception $e) {
            // Retornar un mensaje de error
            return response()->json([
                'error' => 'Error al registrar el usuario'
            ], 500);
        }
    }

    //Metodo para inciar sesion
    public function login(Request $request){
        try{
            //Validar que ingrese el email y password con su tipo
            $data = $request -> validate([
                'email'=> 'string|email|required',
                'password'=>'required|string',
            ]);

            //Buscar el usuario en la tabla
            $user = User::where('email', $data['email'])->first();
            //Verificar que la contrasenia sea la correcta

            if(!$user || !Hash::check($data['password'], $user->password)) {
                throw ValidationException::withMessages([
                    'email'=> ['Las credenciales son incorrectas'],
                ]);
            }

            //Generar el token de acceso
            $token = $user->createToken('clientSecret')->plainTextToken;
            //Retornamos el usuario con su token de acceso
            return response()->json([
                'message'=>'User token',
                'user' => $user,
                'token'=> $token,
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'errors'=> $e->errors()
            ]);
        }catch (\Exception $e) {
            return response()->json([
                'error'=> 'No se pudo iniciar sesion'
            ],500);
        }
    }

    //Metodo para retornar el usuario, ya registrado y logeado
    public function perfil(Request $request){
        try{
            return response()->json(
            $request->user()
            );
        }catch(\Exception $e){
            return response()->json([
                'error' => 'No se pudo obtener la información del usuario.',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    //Metodo para Cerrar sesion
    public function logout(Request $request){
        try{
            $request->user()->currentAccessToken()->delete();
            return response()->json([
                'message'=> 'Sesion Finalizada'
            ], 200);
        }catch(\Exception $e){
            return response()->json([
                'error'=> 'No se pudo cerrar la sesion'
            ]);
        }
    }
}
