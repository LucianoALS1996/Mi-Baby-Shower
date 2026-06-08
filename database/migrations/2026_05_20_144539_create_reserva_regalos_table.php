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

        Schema::create('reserva_regalos', function (Blueprint $table) {

            $table->id('id_reserva');
            $table->foreignId('id_regalo')->constrained('regalo_eventos', 'id_regalo')->onDelete('cascade'); // relacion con regalo_eventos
            $table->foreignId('id_invitado')->constrained('invitados', 'id_invitado')->onDelete('cascade'); // relacion con invitados

            $table->integer('cantidad')->default(1);
            $table->dateTime('fecha_reserva')->nullable();
            $table->string('estado_reserva')->default('reservado'); // 'reservado', 'confirmado', 'cancelado'
            $table->string('estado')->default('activo'); // logica de eliminacion, 'activo', 'cancelado'

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reserva_regalos');
    }
};
