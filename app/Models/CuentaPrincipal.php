<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CuentaPrincipal extends Model
{
    use HasFactory;

    protected $table = 'cuentas_principales';

    protected $fillable = [
        'codigo',
        'nombre',
        'subgrupo_id',
    ];

    public function subgrupo()
    {
        return $this->belongsTo(Subgrupo::class, 'subgrupo_id');
    }

    public function cuentasAnaliticas()
    {
        return $this->hasMany(CuentaAnalitica::class, 'cuenta_principal_id');
    }
}

