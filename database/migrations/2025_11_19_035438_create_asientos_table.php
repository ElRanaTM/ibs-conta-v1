<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('asientos', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->string('glosa');
            $table->boolean('estado')->default(true); // true: activo, false: inactivo
            $table->foreignId('usuario_id')->constrained('users');
            $table->string('numero_asiento', 20)->unique(); // Ej: "ASI-000001"
            $table->string('serie', 10)->default('ASI');
            $table->index(['fecha']);
            $table->index(['estado']);
            $table->index(['numero_asiento']);
            $table->index(['serie']);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('asientos');
    }
};
