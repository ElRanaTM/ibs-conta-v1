<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoCambio extends Model
{
    use HasFactory;

    protected $table = 'tipo_cambio';
    protected $primaryKey = 'id_tc';

    protected $fillable = [
        'id_moneda',
        'fecha',
        'valor',
    ];

    protected $casts = [
        'fecha' => 'date',
        'valor' => 'decimal:4',
    ];

    public function moneda()
    {
        return $this->belongsTo(Moneda::class, 'id_moneda');
    }
}

