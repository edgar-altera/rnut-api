<?php

namespace App\Models;

class Address extends DataCardModel
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
