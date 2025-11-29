<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('numeracion_documentos', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_documento'); // 'pago', 'egreso', 'asiento', 'factura'
            $table->string('serie', 10); // 'PAG', 'EGR', 'ASI', 'FAC'
            $table->string('descripcion'); // 'Comprobantes de Pago', 'Egresos', etc.
            $table->integer('ultimo_numero')->default(0);
            $table->boolean('activo')->default(true);
            $table->timestamps();
            
            $table->unique(['tipo_documento', 'serie']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('numeracion_documentos');
    }
};