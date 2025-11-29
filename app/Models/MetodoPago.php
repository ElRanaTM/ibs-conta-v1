<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MetodoPago extends Model
{
    use HasFactory;

    protected $table = 'metodo_pago';

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    public function pagos()
    {
        return $this->hasMany(Pago::class, 'id_metodo_pago');
    }

    public function detalleAsientos()
    {
        return $this->hasMany(DetalleAsiento::class, 'metodo_pago_id');
    }
}

