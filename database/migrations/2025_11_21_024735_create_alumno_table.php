<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('alumno', function (Blueprint $table) {
            $table->id('id_alumno');
            $table->string('codigo')->unique();
            //$table->string('nombre_completo');
            $table->string('nombres')->nullable();
            $table->string('apellido_paterno')->nullable();
            $table->string('apellido_materno')->nullable();
            $table->string('ci')->nullable();
            $table->string('celular')->nullable();
            $table->string('direccion')->nullable();
            $table->text('observacion')->nullable();
            $table->enum('estado', ['activo','inactivo'])->default('activo');
            $table->index(['codigo']);
            $table->index(['nombres']);
            $table->index(['apellido_paterno']);
            $table->index(['apellido_materno']);
            $table->index(['ci']);
            $table->index(['celular']);
            $table->index(['direccion']);
            $table->index(['estado']);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('alumno');
    }
};

