<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subgrupo extends Model
{
    use HasFactory;

    protected $table = 'subgrupos';

    protected $fillable = [
        'codigo',
        'nombre',
        'grupo_id',
    ];

    public function grupo()
    {
        return $this->belongsTo(Grupo::class, 'grupo_id');
    }

    public function cuentasPrincipales()
    {
        return $this->hasMany(CuentaPrincipal::class, 'subgrupo_id');
    }
}

