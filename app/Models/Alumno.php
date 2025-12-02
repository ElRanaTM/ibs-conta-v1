<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    use HasFactory;

    protected $table = 'alumno';
    protected $primaryKey = 'id_alumno';

    protected $fillable = [
        'codigo',
        'nombres',
        'apellido_paterno',
        'apellido_materno',
        'ci',
        'celular',
        'direccion',
        'observacion',
        'estado',
    ];

    public function pagos()
    {
        return $this->hasMany(Pago::class, 'id_alumno');
    }

    public function apoderados()
    {
        return $this->belongsToMany(Apoderado::class, 'alumno_apoderado', 'id_alumno', 'id_apoderado')
            ->withTimestamps();
    }
}

