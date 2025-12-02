<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('detalle_asientos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asiento_id')->constrained('asientos')->cascadeOnDelete();
            $table->foreignId('cuenta_analitica_id')->constrained('cuentas_analiticas');
            $table->decimal('debe', 12, 2)->default(0);
            $table->decimal('haber', 12, 2)->default(0);
            $table->text('glosa')->nullable();
            $table->foreignId('metodo_pago_id')->nullable()->constrained('metodo_pago');
            $table->index(['asiento_id']);
            $table->index(['cuenta_analitica_id']);
            $table->index(['metodo_pago_id']);
            $table->index(['debe', 'haber']);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('detalle_asientos');
    }
};

