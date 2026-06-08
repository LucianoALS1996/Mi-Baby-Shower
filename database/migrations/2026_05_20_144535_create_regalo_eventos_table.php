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

        Schema::create('regalo_eventos', function (Blueprint $table) {

            $table->id('id_regalo');
            $table->foreignId('id_babyshower')->constrained('babyshowers', 'id_babyshower')->onDelete('cascade');

            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->string('imagen_url')->nullable();
            $table->integer('cantidad_sugerida')->default(0);
            $table->integer('cantidad_reservada')->default(0);
            $table->string('origen_regalo')->default('manual');
            $table->string('estado')->default('activo'); // logica de eliminacion, 'activo', 'inactivo'

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('regalo_eventos');
    }
};
