<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AddressType extends Model
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
