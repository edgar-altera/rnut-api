<?php

namespace App\Models;

class Owner extends RnutModel
{
    protected $table = 'entidad';

    public function vehicles()
    {
        return $this->hasManyThrough(
            Vehicle::class,
            ContractVehicle::class,
            'id_contrato',   // FK en contrato_vehiculo
            'id',            // PK en vehiculo
            'id_contrato',   // FK local en entidad
            'id_vehiculo'    // FK en contrato_vehiculo
        );
    }

    public function contacts()
    {
        return $this->hasMany(
            Contact::class,
            'id_entidad', // FK en contacto
            'id'          // PK en entidad
        );
    }
}
