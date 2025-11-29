<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('alumno_apoderado', function (Blueprint $table) {
            $table->foreignId('id_alumno')->constrained(table: 'alumno', column: 'id_alumno')->cascadeOnDelete();
            $table->foreignId('id_apoderado')->constrained(table: 'apoderado', column: 'id_apoderado')->cascadeOnDelete();
            $table->timestamps();
            $table->primary(['id_alumno', 'id_apoderado']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('alumno_apoderado');
    }
};

