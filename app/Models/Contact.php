<?php

namespace App\Models;

class Contact extends DataCardModel
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

    public function type()
    {
        return $this->belongsTo(
            ContactType::class,
            'tipo', // FK en contacto
            'id'    // PK en contacto_tipo
        );
    }
}
