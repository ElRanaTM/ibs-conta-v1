<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('cuentas_principales', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 10)->unique();
            $table->string('nombre');
            $table->foreignId('subgrupo_id')->constrained('subgrupos');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('cuentas_principales');
    }
};

