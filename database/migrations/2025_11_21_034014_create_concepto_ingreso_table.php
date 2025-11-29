<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('concepto_ingreso', function (Blueprint $table) {
            $table->id('id_concepto');
            $table->string('nombre');
            $table->string('tipo');
            $table->decimal('monto_base', 12, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('concepto_ingreso');
    }
};

