<?php

namespace App\Models;

class Owner extends DataCardModel
{
    protected $table = 'entidad';

    public function contractVehicle()
    {
        return $this->hasOne(
            ContractVehicle::class,
            'id_contrato',
            'id_contrato'
        );
    }

    public function vehicle()
    {
        return $this->hasOneThrough(
            Vehicle::class,
            ContractVehicle::class,
            'id_contrato',   // contrato_vehiculo → entidad
            'id',            // vehiculo PK
            'id_contrato',   // entidad
            'id_vehiculo'    // contrato_vehiculo → vehiculo
        );
    }

    public function address()
    {
        return $this->hasOne(
            Address::class,
            'id_contrato', // FK en direccion
            'id_contrato'  // PK lógica en entidad
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
