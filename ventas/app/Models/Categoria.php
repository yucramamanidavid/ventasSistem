<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    // Definir la tabla asociada (si no sigue la convención de Laravel)
    protected $table = 'categorias';

    // Definir los campos que son asignables masivamente
    protected $fillable = [
        'nombre', // Asegúrate de que los campos correspondan con los de tu migración
    ];

    // Relación con los productos (si la necesitas)
    public function productos()
    {
        return $this->hasMany(Producto::class);
    }
}
