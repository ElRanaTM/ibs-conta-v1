<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('apoderado', function (Blueprint $table) {
            $table->id('id_apoderado');
            $table->string('nombre_completo');
            $table->string('ci');
            $table->string('celular')->nullable();
            $table->string('direccion')->nullable();
            $table->string('relacion_legal');
            $table->text('observacion')->nullable();
            $table->timestamps();
            $table->index(['nombre_completo']);
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
