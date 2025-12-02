<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleAsiento extends Model
{
    use HasFactory;

    protected $table = 'detalle_asientos';

    protected $fillable = [
        'asiento_id',
        'cuenta_analitica_id',
        'debe',
        'haber',
        'glosa',
        'metodo_pago_id',
    ];

    protected $casts = [
        'debe' => 'decimal:2',
        'haber' => 'decimal:2',
    ];

    public function asiento()
    {
        return $this->belongsTo(Asiento::class, 'asiento_id');
    }

    public function cuentaAnalitica()
    {
        return $this->belongsTo(CuentaAnalitica::class, 'cuenta_analitica_id');
    }

    public function metodoPago()
    {
        return $this->belongsTo(MetodoPago::class, 'metodo_pago_id');
    }
}

