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
        Schema::create('invitacion_envios', function (Blueprint $table) {

            $table->id('id_envio');
            $table->foreignId('id_invitado')->constrained('invitados', 'id_invitado')->onDelete('cascade');

            $table->string('canal')->default('correo'); // esto se puede moficiar por tipo de envio a futuro
            $table->dateTime('fecha_envio')->nullable();
            $table->string('estado_envio')->default('pendiente');
            $table->string('estado')->default('activo'); // logica de eliminacion, 'activo', 'inactivo'

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invitacion_envios');
    }
};
