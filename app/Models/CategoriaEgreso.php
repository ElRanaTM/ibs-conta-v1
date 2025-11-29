<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriaEgreso extends Model
{
    use HasFactory;

    protected $table = 'categoria_egreso';
    protected $primaryKey = 'id_categoria';

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    public function egresos()
    {
        return $this->hasMany(Egreso::class, 'id_categoria');
    }
}

