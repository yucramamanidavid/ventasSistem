<?php

// app/Http/Controllers/AuthController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Validator;

class AuthController extends Controller

{
    // Registro de un nuevo usuario
     // Método de registro
    // Método para registrar un usuario
    public function register(Request $request)
    {
        // Validar los datos recibidos
        $validator = validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed', // Asegura que las contraseñas coincidan
            'role' => 'required|string|in:admin,cliente', // Validamos que el rol sea admin o cliente
        ]);

        // Si la validación falla, retornamos el error
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validación fallida',
                'errors' => $validator->errors(),
            ], 400);
        }

        // Crear el nuevo usuario
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        // Retornar una respuesta exitosa
        return response()->json([
            'message' => 'Usuario registrado exitosamente',
            'user' => $user,
        ], 201);
    }
    // Login del usuario y generar token
    public function login(Request $request)
{
    $credentials = $request->only('email', 'password');

    // Intentar autenticar al usuario
    if (Auth::attempt($credentials)) {
        $user = Auth::user();

        // Verificar el rol del usuario
        if ($user->role == 'cliente') {
            return response()->json([
                'user' => $user,
                'message' => 'Login exitoso'
            ]);
        } elseif ($user->role == 'admin') {
            return response()->json([
                'user' => $user,
                'message' => 'Login exitoso'
            ]);
        } else {
            return response()->json(['message' => 'Rol no reconocido'], 403);
        }
    } else {
        return response()->json(['message' => 'Credenciales incorrectas'], 401);
    }
}


    // Obtener los datos del usuario autenticado
    public function user(Request $request)
    {
        return response()->json($request->user());
    }
    public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:6|confirmed',
        'role' => 'required|string',
    ]);

    // Si la validación pasa, creamos el usuario
    $user = User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => bcrypt($validated['password']),
        'role' => $validated['role'],
    ]);

    return response()->json(['message' => 'Usuario registrado con éxito.'], 201);
}

}
