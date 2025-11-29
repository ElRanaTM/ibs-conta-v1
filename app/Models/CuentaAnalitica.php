<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CuentaAnalitica extends Model
{
    use HasFactory;

    protected $table = 'cuentas_analiticas';

    protected $fillable = [
        'codigo',
        'nombre',
        'cuenta_principal_id',
        'es_auxiliar',
    ];

    protected $casts = [
        'es_auxiliar' => 'boolean',
    ];

    public function cuentaPrincipal()
    {
        return $this->belongsTo(CuentaPrincipal::class, 'cuenta_principal_id');
    }

    public function detalleAsientos()
    {
        return $this->hasMany(DetalleAsiento::class, 'cuenta_analitica_id');
    }
}

