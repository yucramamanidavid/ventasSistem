<?php

namespace App\Http\Controllers;

use App\Models\Envio;
use Illuminate\Http\Request;

class EnvioController extends Controller
{
    // Método para obtener todos los envíos
    public function index()
    {
        return response()->json(Envio::all());
    }

    // Método para crear un nuevo envío
    public function store(Request $request)
    {
        // Validación de los datos recibidos
        $validated = $request->validate([
            'nombre_destinatario' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'codigo_postal' => 'required|string|max:10',
        ]);

        // Crear el envío en la base de datos
        $envio = Envio::create($validated);

        // Retornar el envío creado con el status 201 (Creado)
        return response()->json($envio, 201);
    }

    // Método para obtener un envío específico
    public function show($id)
    {
        // Buscar el envío por su ID
        $envio = Envio::findOrFail($id);

        // Retornar el envío encontrado
        return response()->json($envio);
    }

    // Método para actualizar un envío
    public function update(Request $request, $id)
    {
        // Validación de los datos recibidos
        $validated = $request->validate([
            'nombre_destinatario' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'codigo_postal' => 'required|string|max:10',
        ]);

        // Buscar el envío por ID
        $envio = Envio::findOrFail($id);

        // Actualizar los datos del envío
        $envio->update($validated);

        // Retornar el envío actualizado
        return response()->json($envio);
    }

    // Método para eliminar un envío
    public function destroy($id)
    {
        // Eliminar el envío por su ID
        Envio::destroy($id);

        // Retornar mensaje de éxito
        return response()->json(['message' => 'Envío eliminado con éxito']);
    }
}
