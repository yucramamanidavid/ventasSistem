<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Ejecutar la migración.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();  // ID único para cada pedido
            $table->foreignId('user_id')->constrained()->onDelete('cascade');  // Relación con el usuario
            $table->decimal('total', 10, 2);  // Total de la compra
            $table->enum('status', ['pending', 'processing', 'completed', 'cancelled'])->default('pending');  // Estado del pedido
            $table->string('shipping_address');  // Dirección de envío
            $table->timestamps();  // Fechas de creación y actualización
        });
    }

    /**
     * Deshacer la migración.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
