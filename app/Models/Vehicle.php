<?php

namespace App\Models;

class Vehicle extends RnutModel
{
    protected $table = 'vehiculo';

    public function contract()
    {
        return $this->hasOne(
            ContractVehicle::class,
            'id_vehiculo',
            'id'
        );
    }

    public function owner()
    {
        return $this->hasOneThrough(
            Owner::class,
            ContractVehicle::class,
            'id_vehiculo',   // FK en contrato_vehiculo → vehiculo
            'id_contrato',   // PK en entidad
            'id',            // PK vehiculo
            'id_contrato'    // FK contrato_vehiculo → entidad
        );
    }

    public function urbanCategory()
    {
        return $this->belongsTo(
            UrbanCategory::class,
            'id_categoria_urbana'
        );
    }

    public function interurbanCategory()
    {
        return $this->belongsTo(
            InterurbanCategory::class,
            'id_categoria_interurbana'
        );
    }
}
