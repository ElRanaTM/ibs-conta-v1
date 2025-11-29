<?php

namespace App\Services;

use App\Models\NumeracionDocumentos;
use Illuminate\Support\Facades\DB;

class NumeracionService {

    public static function generarNumero($tipoDocumento, $serie = null) {

        $numeracion = NumeracionDocumentos::where('tipo_documento', $tipoDocumento)

            ->when($serie, function($query) use ($serie) {

                return $query->where('serie', $serie);

            })

            ->where('activo', true)

            ->firstOrFail();

        // Bloquear para evitar duplicados en concurrencia
        $nuevoNumero = DB::transaction(function() use ($numeracion) {
            $numeracion->lockForUpdate();
            $numeracion->increment('ultimo_numero');
            $numeracion->refresh();
            return str_pad($numeracion->ultimo_numero, 6, '0', STR_PAD_LEFT);
        });

        return "{$numeracion->serie}-{$nuevoNumero}";

    }

}

