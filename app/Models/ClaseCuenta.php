<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClaseCuenta extends Model
{
    use HasFactory;

    protected $table = 'clases_cuenta';

    protected $fillable = [
        'codigo',
        'nombre',
    ];

    public function grupos()
    {
        return $this->hasMany(Grupo::class, 'clase_id');
    }
}

