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
        Schema::create('capituloms', function (Blueprint $table) {
            $table->id();
            $table->string('congreso');
            $table->string('estado_region');
            $table->string('ciudad');
            $table->string('revision');
            $table->integer('pagina_inicio');
            $table->integer('pagina_fin');
            $table->string('isbn')->nullable();
            $table->string('issn')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('capituloms');
    }
};
