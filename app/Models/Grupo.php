<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    use HasFactory;

    protected $table = 'grupos';

    protected $fillable = [
        'codigo',
        'nombre',
        'clase_id',
    ];

    public function clase()
    {
        return $this->belongsTo(ClaseCuenta::class, 'clase_id');
    }

    public function subgrupos()
    {
        return $this->hasMany(Subgrupo::class, 'grupo_id');
    }
}

