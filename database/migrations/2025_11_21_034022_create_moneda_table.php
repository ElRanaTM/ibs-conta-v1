<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('moneda', function (Blueprint $table) {
            $table->id('id_moneda');
            $table->string('nombre');
            $table->string('abreviatura', 5);
            $table->string('simbolo', 5);
            $table->boolean('es_local')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('moneda');
    }
};

