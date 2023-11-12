<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
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
            $table->foreignId('sector_id')->nullable()->constrained('sectores');
            $table->foreignId('subsector_id')->nullable()->constrained('subsectores');
            $table->string('area_prioritaria_pais')->nullable();
            $table->string('area_conocimiento')->nullable();
            $table->date('fecha_publicacion')->nullable();
            $table->string('pais_publicacion')->nullable();
            $table->string('evidencia')->nullable();
            $table->foreignId('user_id')->constrained(); # FK -> Users
            $table->unsignedBigInteger('registrable_id')->nullable();
            $table->string('registrable_type')->nullable();
            $table->timestamps();
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
