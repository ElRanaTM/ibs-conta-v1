<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Egreso extends Model
{
    use HasFactory;

    protected $table = 'egreso';
    protected $primaryKey = 'id_egreso';

    protected $fillable = [
        'id_proveedor',
        'id_categoria',
        'fecha',
        'monto',
        'descripcion',
        'id_asiento',
        'id_moneda',
        'numero_comprobante',
        'serie',
    ];

    protected $casts = [
        'fecha' => 'date',
        'monto' => 'decimal:2',
    ];

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'id_proveedor');
    }

    public function categoria()
    {
        return $this->belongsTo(CategoriaEgreso::class, 'id_categoria');
    }

    public function asiento()
    {
        return $this->belongsTo(Asiento::class, 'id_asiento');
    }

    public function moneda()
    {
        return $this->belongsTo(Moneda::class, 'id_moneda');
    }
}

