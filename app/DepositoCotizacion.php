<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DepositoCotizacion extends Model
{

     protected $table = "depositos_cotizaciones";

     protected $fillable = [
        'deposito_id', 'cotizacion_id', 'monto_deposito_asignado',
    ];
}
