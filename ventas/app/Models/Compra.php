<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;

    // Define la tabla asociada al modelo
    protected $table = 'compras';  // Nombre de la tabla de compras

    // Campos que pueden ser asignados masivamente
    protected $fillable = ['producto_id', 'cantidad', 'precio_total', 'user_id', 'estado_pago'];

    // Relación con el producto
    public function producto()
    {
        // Una compra pertenece a un solo producto
        return $this->belongsTo(Producto::class, 'producto_id');
    }

    // Relación con el usuario
    public function user()
    {
        // Una compra pertenece a un solo usuario
        return $this->belongsTo(User::class, 'user_id');
    }

    // Puedes agregar otras funciones según tu necesidad, como calcular el total de la compra, etc.
}
