<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('tipo_cambio', function (Blueprint $table) {
            $table->id('id_tc');
            $table->foreignId('id_moneda')->constrained(table: 'moneda', column: 'id_moneda');
            $table->date('fecha');
            $table->decimal('valor', 12, 4);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('tipo_cambio');
    }
};

