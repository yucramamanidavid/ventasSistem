<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria; // Asegúrate de importar el modelo Categoria
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{
    // Fetch all products with their categories
    public function index()
    {
        // Fetch all products and include the category
        $productos = Producto::with('categoria')->get();

        // Asegurarse de que la imagen se devuelva con una URL accesible
        foreach ($productos as $producto) {
            if ($producto->imagen) {
                $producto->imagen = asset('storage/' . $producto->imagen); // Construir la URL completa
            }
        }

        return response()->json($productos);
    }


    // Store a new product
    public function store(Request $request)
    {
        // Validación de la solicitud
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric',
            'stock' => 'required|integer',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validación para imagen
            'categoria_id' => 'required|exists:categorias,id', // Validación para el campo categoria_id
        ]);

        // Si se envió una imagen, guardarla en el almacenamiento
        if ($request->hasFile('imagen') && $request->file('imagen')->isValid()) {
            $validated['imagen'] = $request->file('imagen')->store('imagenes', 'public');
        }

        // Crear el producto con los datos validados
        $producto = Producto::create($validated);

        return response()->json($producto, 201);
    }

    // Show a specific product by ID
    public function show($id)
    {
        // Buscar el producto por ID, incluyendo su categoría
        $producto = Producto::with('categoria')->findOrFail($id);
        return response()->json($producto);
    }

    // Update a product by ID
    public function update(Request $request, $id)
    {
        // Buscar el producto por ID
        $producto = Producto::findOrFail($id);

        // Validación de la solicitud
        $validated = $request->validate([
            'nombre' => 'sometimes|required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'sometimes|required|numeric',
            'stock' => 'sometimes|required|integer',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validación para imagen
            'categoria_id' => 'sometimes|required|exists:categorias,id', // Validación para categoria_id
        ]);

        // Si se envió una nueva imagen, reemplazar la existente
        if ($request->hasFile('imagen') && $request->file('imagen')->isValid()) {
            // Eliminar la imagen antigua si existe
            if ($producto->imagen) {
                Storage::disk('public')->delete($producto->imagen);
            }
            // Guardar la nueva imagen
            $validated['imagen'] = $request->file('imagen')->store('imagenes', 'public');
        }

        // Actualizar el producto con los datos validados
        $producto->update($validated);

        return response()->json($producto);
    }

    // Delete a product by ID
    public function destroy($id)
    {
        // Buscar el producto por ID
        $producto = Producto::findOrFail($id);

        // Eliminar la imagen asociada si existe
        if ($producto->imagen) {
            Storage::disk('public')->delete($producto->imagen);
        }

        // Eliminar el producto
        $producto->delete();

        return response()->json(null, 204);
    }
}
