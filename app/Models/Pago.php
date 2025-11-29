<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;

    protected $table = 'pago';
    protected $primaryKey = 'id_pago';

    protected $fillable = [
        'id_alumno',
        'id_concepto',
        'fecha_pago',
        'id_periodo',
        'monto',
        'id_moneda',
        'id_metodo_pago',
        'referencia_pago',
        'estado_pago',
        'id_asiento',
        'numero_comprobante',
        'serie',
        'id_numeracion_documento',
    ];

    protected $casts = [
        'fecha_pago' => 'date',
        'monto' => 'decimal:2',
    ];

    public function alumno()
    {
        return $this->belongsTo(Alumno::class, 'id_alumno');
    }

    public function concepto()
    {
        return $this->belongsTo(ConceptoIngreso::class, 'id_concepto');
    }

    public function periodo()
    {
        return $this->belongsTo(PeriodoAcademico::class, 'id_periodo');
    }

    public function moneda()
    {
        return $this->belongsTo(Moneda::class, 'id_moneda');
    }

    public function metodoPago()
    {
        return $this->belongsTo(MetodoPago::class, 'id_metodo_pago');
    }

    public function asiento()
    {
        return $this->belongsTo(Asiento::class, 'id_asiento');
    }

    public function numeracionDocumento()
    {
        return $this->belongsTo(NumeracionDocumentos::class, 'id_numeracion_documento');
    }
}

