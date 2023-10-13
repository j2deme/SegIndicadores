<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('articulos', function (Blueprint $table) {
            $table->id();
            $table->string('revista');
            $table->string('estatus');
            $table->string('tipo');
            $table->integer('volumen');
            $table->string('indice');
            $table->string('url');
            $table->integer('pagina_inicio');
            $table->integer('pagina_fin');
            $table->string('isbn')->nullable();
            $table->string('issn')->nullable();
            $table->string('casa_editorial');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articulos');
    }
};
