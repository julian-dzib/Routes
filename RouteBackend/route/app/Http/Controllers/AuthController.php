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
        //Validar los campos
        $data = $request->validate( [
            'name'=> 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password'=> ['required','string',Password::min(10)],
        ]);
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
    }

    //Metodo para inciar sesion
    public function login(Request $request){
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
    }

    //Metodo para retornar el usuario, ya registrado y logeado
    public function perfil(Request $request){
        return response()->json(
            $request->user()
        );
    }

    //Metodo para Cerrar sesion
    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message'=> 'Sesion Finalizada'
        ], 200);
    }
}
