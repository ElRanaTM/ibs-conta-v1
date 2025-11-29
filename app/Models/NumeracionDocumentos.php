<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NumeracionDocumentos extends Model
{
    use HasFactory;

    protected $table = 'numeracion_documentos';

    protected $fillable = [
        'tipo_documento',
        'serie',
        'descripcion',
        'ultimo_numero',
        'activo',
    ];

    protected $casts = [
        'ultimo_numero' => 'integer',
        'activo' => 'boolean',
    ];
}

