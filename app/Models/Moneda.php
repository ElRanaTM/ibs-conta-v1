<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Moneda extends Model
{
    use HasFactory;

    protected $table = 'moneda';
    protected $primaryKey = 'id_moneda';

    protected $fillable = [
        'nombre',
        'abreviatura',
        'simbolo',
        'es_local',
    ];

    protected $casts = [
        'es_local' => 'boolean',
    ];

    public function pagos()
    {
        return $this->hasMany(Pago::class, 'id_moneda');
    }

    public function egresos()
    {
        return $this->hasMany(Egreso::class, 'id_moneda');
    }

    public function tiposCambio()
    {
        return $this->hasMany(TipoCambio::class, 'id_moneda');
    }
}

