<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('compras', function (Blueprint $table) {
        $table->enum('estado_pago', ['simulado', 'pendiente', 'completado'])->default('simulado');
    });
}

public function down()
{
    Schema::table('compras', function (Blueprint $table) {
        $table->dropColumn('estado_pago');
    });
}

};
