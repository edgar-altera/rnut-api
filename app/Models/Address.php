<?php

namespace App\Models;

class Address extends DataCarModel
{
    protected $table = 'direccion';

    public function addressType()
    {
        return $this->belongsTo(
            AddressType::class,
            'tipo', // FK en addresses
            'id'    // PK en address_types
        );
    }
}
