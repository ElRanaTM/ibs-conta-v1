<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asiento extends Model
{
    use HasFactory;

    protected $table = 'asientos';

    protected $fillable = [
        'fecha',
        'glosa',
        'estado',
        'usuario_id',
        'numero_asiento',
        'serie',
    ];

    protected $casts = [
        'fecha' => 'date',
        'estado' => 'boolean',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function detalleAsientos()
    {
        return $this->hasMany(DetalleAsiento::class, 'asiento_id');
    }

    public function pagos()
    {
        return $this->hasMany(Pago::class, 'id_asiento');
    }

    public function egresos()
    {
        return $this->hasMany(Egreso::class, 'id_asiento');
    }
}

