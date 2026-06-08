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
        Schema::create('babyshowers', function (Blueprint $table) {
            $table->id('id_babyshower');
            $table->foreignId('id_usuario')->constrained('usuarios', 'id_usuario')->onDelete('cascade');

            $table->string('titulo');
            $table->dateTime('fecha_evento');
            $table->string('lugar');
            $table->text('descripcion')->nullable();
            $table->string('portada_url')->nullable();
            $table->string('estado')->default('activo'); // logica de eliminacion, 'activo', 'inactivo'

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('babyshowers');
    }
};
