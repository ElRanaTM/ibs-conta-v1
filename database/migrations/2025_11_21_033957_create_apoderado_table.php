<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('apoderado', function (Blueprint $table) {
            $table->id('id_apoderado');
            //$table->string('nombre_completo');
            $table->string('nombres')->nullable();
            $table->string('apellido_paterno')->nullable();
            $table->string('apellido_materno')->nullable();
            $table->string('ci');
            $table->string('celular')->nullable();
            $table->string('direccion')->nullable();
            $table->string('relacion_legal');
            $table->text('observacion')->nullable();
            $table->timestamps();
            $table->index(['nombres']);
            $table->index(['apellido_paterno']);
            $table->index(['apellido_materno']);
            $table->index(['ci']);
            $table->index(['celular']);
            $table->index(['direccion']);
            $table->index(['relacion_legal']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('apoderado');
    }
};
