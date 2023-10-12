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
        Schema::create('registros', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('proposito')->nullable();
            $table->string('autores');
            $table->tinyInteger('posicion_autor')->nullable();
            $table->text('descripcion')->nullable();
            $table->unsignedBigInteger('sector_estrategico')->nullable(); # FK
            $table->unsignedBigInteger('subsector_estrategico')->nullable(); #FK
            $table->string('area_prioritaria_pais')->nullable();
            $table->string('area_conocimiento')->nullable();
            $table->date('fecha_publicacion')->nullable();
            $table->string('pais_publicacion')->nullable();
            $table->string('evidencia')->nullable();
            $table->unsignedBigInteger('user_id'); # FK -> Users
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registros');
    }
};
