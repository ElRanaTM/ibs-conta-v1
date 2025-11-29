<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;

    protected $table = 'proveedor';
    protected $primaryKey = 'id_proveedor';

    protected $fillable = [
        'nombre',
        'nit',
        'telefono',
        'direccion',
    ];

    public function egresos()
    {
        return $this->hasMany(Egreso::class, 'id_proveedor');
    }
}

