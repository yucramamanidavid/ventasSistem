<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Asegúrate de importar Auth para obtener el usuario autenticado
use Illuminate\Support\Facades\Log;  // Asegúrate de importar Log para crear registros

class CompraController extends Controller
{
    // Método para procesar una compra
    public function createCompra(Request $request)
    {
        // Log para verificar los datos recibidos
        Log::info("Datos recibidos para la compra:", $request->all());

        // Validar los datos de la solicitud
        $request->validate([
            'productos' => 'required|array',
            'productos.*.producto_id' => 'required|exists:productos,id',  // Validar que el producto exista
            'productos.*.cantidad' => 'required|integer|min:1',  // Validar cantidad
            'productos.*.precio_total' => 'required|numeric|min:0',  // Validar precio total
        ]);

        // Verificar que el 'user_id' esté presente
        $userId = $request->user_id;
        Log::info("User ID recibido: " . $userId);  // Log para verificar que el user_id está presente

        if (!$userId) {
            return response()->json(['message' => 'User ID es requerido'], 400);
        }

        // Procesar la compra
        foreach ($request->productos as $productoData) {
            $producto = Producto::find($productoData['producto_id']);

            // Verificar stock disponible
            if ($producto && $producto->stock >= $productoData['cantidad']) {
                // Crear la compra
                $compra = Compra::create([
                    'producto_id' => $productoData['producto_id'],
                    'cantidad' => $productoData['cantidad'],
                    'precio_total' => $productoData['precio_total'],
                    'user_id' => $userId,
                    'estado_pago' => 'simulado',  // Inicializar el estado de pago como simulado
                ]);

                // Actualizar el stock del producto
                $producto->stock -= $productoData['cantidad'];
                $producto->save();

                // Registrar el estado de la compra en el log
                Log::info("Compra creada con éxito: ", $compra->toArray());
            } else {
                // Si el stock no es suficiente
                Log::warning("Stock insuficiente para el producto ID: " . $productoData['producto_id']);
                return response()->json(['message' => 'Stock insuficiente para el producto: ' . $productoData['producto_id']], 400);
            }
        }

        // Retornar una respuesta exitosa
        return response()->json(['message' => 'Compra realizada con éxito. Pago simulado.'], 200);
    }

    // Método para simular el cambio de estado del pago a "completado" (si se implementa el proceso de pago real)
    public function completarPago(Request $request, $compraId)
    {
        // Buscar la compra
        $compra = Compra::find($compraId);

        if (!$compra) {
            return response()->json(['message' => 'Compra no encontrada'], 404);
        }

        // Cambiar el estado de pago a "completado"
        $compra->estado_pago = 'completado';
        $compra->save();

        // Log para verificar el cambio de estado
        Log::info("Pago completado para la compra ID: " . $compraId);

        return response()->json(['message' => 'Pago completado con éxito.'], 200);
    }
    // app/Http/Controllers/CompraController.php
public function obtenerCompras()
{
    // Lógica para obtener las compras desde la base de datos
    $compras = Compra::all();  // O la lógica que necesites para obtener las compras
    return response()->json($compras);
}

}
