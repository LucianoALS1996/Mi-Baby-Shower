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
        Schema::create('invitados', function (Blueprint $table) {
            $table->id('id_invitado'); // Id autoincremental
            $table->foreignId('id_babyshower')->constrained('babyshowers', 'id_babyshower')->onDelete('cascade');

            $table->string('nombre');
            $table->string('telefono')->nullable();
            $table->string('email')->nullable();
            $table->string('token_invitacion')->unique();
            $table->dateTime('token_expira')->nullable();
            $table->string('estado_invitacion')->default('pendiente');
            $table->string('estado_asistencia')->default('pendiente');
            $table->string('canal_preferido')->default('email');
            $table->dateTime('ultimo_acceso')->nullable();
            $table->string('estado')->default('activo'); // logica de eliminacion, 'activo', 'inactivo'

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invitados');
    }
};
