<?php

namespace App\Models;

class ContractVehicle extends DataCardModel
{
    protected $table = 'contrato_vehiculo';
    public $timestamps = false;

    public function owner()
    {
        return $this->belongsTo(
            Owner::class,
            'id_contrato',
            'id_contrato'
        );
    }

    public function vehicle()
    {
        return $this->belongsTo(
            Vehicle::class,
            'id_vehiculo'
        );
    }
}
