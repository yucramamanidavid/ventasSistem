<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoriaController extends Controller
{
    // Obtener todas las categorías
    public function index()
    {
        try {
            $categorias = Categoria::all();
            return response()->json($categorias, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener las categorías', 'details' => $e->getMessage()], 500);
        }
    }

    // Crear una nueva categoría
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:categorias,nombre',
        ]);

        DB::beginTransaction();
        try {
            $categoria = new Categoria();
            $categoria->nombre = $request->nombre;
            $categoria->save();

            DB::commit();
            return response()->json(['message' => 'Categoría creada exitosamente', 'data' => $categoria], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Error al crear la categoría', 'details' => $e->getMessage()], 500);
        }
    }

    // Obtener una categoría específica
    public function show($id)
    {
        try {
            $categoria = Categoria::find($id);

            if (!$categoria) {
                return response()->json(['message' => 'Categoría no encontrada'], 404);
            }

            return response()->json($categoria, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener la categoría', 'details' => $e->getMessage()], 500);
        }
    }

    // Actualizar una categoría existente
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'sometimes|string|max:255|unique:categorias,nombre,' . $id,
        ]);

        DB::beginTransaction();
        try {
            $categoria = Categoria::find($id);

            if (!$categoria) {
                return response()->json(['message' => 'Categoría no encontrada'], 404);
            }

            $categoria->nombre = $request->nombre ?? $categoria->nombre;
            $categoria->save();

            DB::commit();
            return response()->json(['message' => 'Categoría actualizada exitosamente', 'data' => $categoria], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Error al actualizar la categoría', 'details' => $e->getMessage()], 500);
        }
    }

    // Eliminar una categoría
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $categoria = Categoria::find($id);

            if (!$categoria) {
                return response()->json(['message' => 'Categoría no encontrada'], 404);
            }

            $categoria->delete();
            DB::commit();
            return response()->json(['message' => 'Categoría eliminada exitosamente'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Error al eliminar la categoría', 'details' => $e->getMessage()], 500);
        }
    }
}
