<?php

namespace App\Models;

class AddressType extends DataCarModel
{
    protected $table = 'tipo_direccion';

    public function addresses()
    {
        return $this->hasMany(
            Address::class,
            'tipo',
            'id'
        );
    }
}
