<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('egreso', function (Blueprint $table) {
            $table->id('id_egreso');
            $table->foreignId('id_proveedor')->nullable()->constrained(table: 'proveedor', column: 'id_proveedor');
            $table->foreignId('id_categoria')->nullable()->constrained(table: 'categoria_egreso', column: 'id_categoria');
            $table->date('fecha');
            $table->decimal('monto', 12, 2);
            $table->text('descripcion')->nullable();
            $table->foreignId('id_asiento')->nullable()->constrained(table: 'asientos', column: 'id');
            $table->foreignId('id_moneda')->constrained(table: 'moneda', column: 'id_moneda');
            $table->string('numero_comprobante', 20)->unique(); // Ej: "EGR-000001"
            $table->string('serie', 10)->default('EGR');
            $table->index(['id_categoria', 'fecha']);
            $table->index(['numero_comprobante']);
            $table->index(['fecha']);
            $table->index(['id_proveedor']);
            $table->index(['id_categoria']);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('egreso');
    }
};
