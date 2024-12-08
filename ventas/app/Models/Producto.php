<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    // Define el nombre de la tabla (opcional si sigue las convenciones de Laravel)
    protected $table = 'productos';  // Nombre de la tabla

    // Define los atributos asignables en operaciones masivas
    protected $fillable = ['nombre', 'descripcion', 'precio', 'stock', 'imagen', 'categoria_id']; // Agregado 'categoria_id'

    // Habilita timestamps si tu tabla tiene created_at y updated_at
    public $timestamps = true;

    // Define tipos de datos para los atributos
    protected $casts = [
        'precio' => 'float',  // Asegura que 'precio' sea tratado como float
        'stock' => 'integer', // Asegura que 'stock' sea tratado como entero
    ];

    // Método personalizado para calcular el valor total de productos en stock
    public function totalStockValue()
    {
        return $this->precio * $this->stock;
    }

    // Relación con las órdenes (un producto puede estar en muchas órdenes)
    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }

    // Relación con la categoría (un producto pertenece a una categoría)
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');  // Relacionado con el campo 'categoria_id'
    }
}
