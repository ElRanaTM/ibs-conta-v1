<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apoderado extends Model
{
    use HasFactory;

    protected $table = 'apoderado';
    protected $primaryKey = 'id_apoderado';

    protected $fillable = [
        'nombres',
        'apellido_paterno',
        'apellido_materno',
        'ci',
        'celular',
        'direccion',
        'relacion_legal',
        'observacion',
    ];

    public function alumnos()
    {
        return $this->belongsToMany(Alumno::class, 'alumno_apoderado', 'id_apoderado', 'id_alumno')
            ->withTimestamps();
    }
}

