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
    Schema::table('productos', function (Blueprint $table) {
        $table->unsignedBigInteger('categoria_id')->nullable();
 // Relacionar con la tabla categorias
        $table->foreign('categoria_id')->references('id')->on('categorias')->onDelete('cascade');
    });
}

public function down()
{
    Schema::table('productos', function (Blueprint $table) {
        $table->dropForeign(['categoria_id']);
        $table->dropColumn('categoria_id');
    });
}

};
