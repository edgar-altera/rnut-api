<?php

namespace App\Models;

class Contact extends RnutModel
{
    protected $table = 'contacto';

    public function owner()
    {
        return $this->belongsTo(
            Owner::class,
            'id_entidad',
            'id'
        );
    }
}
