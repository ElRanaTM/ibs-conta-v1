<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('alumno', function (Blueprint $table) {
            if (!Schema::hasColumn('alumno', 'nombres')) {
                $table->string('nombres')->nullable()->after('codigo');
            }
            if (!Schema::hasColumn('alumno', 'apellido_paterno')) {
                $table->string('apellido_paterno')->nullable()->after('nombres');
            }
            if (!Schema::hasColumn('alumno', 'apellido_materno')) {
                $table->string('apellido_materno')->nullable()->after('apellido_paterno');
            }
        });

        Schema::table('apoderado', function (Blueprint $table) {
            if (!Schema::hasColumn('apoderado', 'nombres')) {
                $table->string('nombres')->nullable()->after('id_apoderado');
            }
            if (!Schema::hasColumn('apoderado', 'apellido_paterno')) {
                $table->string('apellido_paterno')->nullable()->after('nombres');
            }
            if (!Schema::hasColumn('apoderado', 'apellido_materno')) {
                $table->string('apellido_materno')->nullable()->after('apellido_paterno');
            }
        });
    }

    public function down(): void {
        Schema::table('alumno', function (Blueprint $table) {
            if (Schema::hasColumn('alumno', 'nombres')) $table->dropColumn('nombres');
            if (Schema::hasColumn('alumno', 'apellido_paterno')) $table->dropColumn('apellido_paterno');
            if (Schema::hasColumn('alumno', 'apellido_materno')) $table->dropColumn('apellido_materno');
        });

        Schema::table('apoderado', function (Blueprint $table) {
            if (Schema::hasColumn('apoderado', 'nombres')) $table->dropColumn('nombres');
            if (Schema::hasColumn('apoderado', 'apellido_paterno')) $table->dropColumn('apellido_paterno');
            if (Schema::hasColumn('apoderado', 'apellido_materno')) $table->dropColumn('apellido_materno');
        });
    }
};
