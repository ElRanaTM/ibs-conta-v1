<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pago', function (Blueprint $table) {
            $table->id('id_pago');
            $table->foreignId('id_alumno')->constrained(table: 'alumno', column: 'id_alumno');
            $table->foreignId('id_concepto')->constrained(table: 'concepto_ingreso', column: 'id_concepto');
            $table->date('fecha_pago');
            $table->foreignId('id_periodo')->constrained(table: 'periodo_academico', column: 'id_periodo');
            $table->decimal('monto', 12, 2);
            $table->foreignId('id_moneda')->constrained(table: 'moneda', column: 'id_moneda');
            $table->foreignId('id_metodo_pago')->constrained(table: 'metodo_pago', column: 'id');
            $table->string('referencia_pago')->nullable();
            $table->enum('estado_pago', ['pagado','pendiente','anulado'])->default('pagado');
            $table->foreignId('id_asiento')->nullable()->constrained(table: 'asientos', column: 'id');
            $table->string('numero_comprobante', 20)->unique(); // Ej: "PAG-000001"
            $table->string('serie', 10)->default('PAG');
            $table->foreignId('id_numeracion_documento')->constrained(table: 'numeracion_documentos', column: 'id');
            $table->index(['id_alumno', 'fecha_pago']);
            $table->index(['estado_pago']);
            $table->index(['id_concepto']);
            $table->index(['fecha_pago']);
            $table->index(['numero_comprobante']);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('pago');
    }
};

