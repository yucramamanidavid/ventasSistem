<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // Si el nombre de la tabla en la base de datos no sigue la convención plural
    // puedes especificar el nombre explícitamente
    protected $table = 'orders';

    // Definir los campos que pueden ser asignados masivamente
    protected $fillable = [
        'user_id',
        'total',
        'status',
        'shipping_address'
    ];

    // Relación con el modelo User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
