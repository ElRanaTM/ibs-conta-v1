<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConceptoIngreso extends Model
{
    use HasFactory;

    protected $table = 'concepto_ingreso';
    protected $primaryKey = 'id_concepto';

    protected $fillable = [
        'nombre',
        'tipo',
        'monto_base',
    ];

    protected $casts = [
        'monto_base' => 'decimal:2',
    ];

    public function pagos()
    {
        return $this->hasMany(Pago::class, 'id_concepto');
    }
}

