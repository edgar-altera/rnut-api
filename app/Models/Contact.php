<?php

namespace App\Models;

class Contact extends RnutModel
{
    protected $table = 'contacto';

    protected static function booted()
    {
        static::addGlobalScope('active', fn ($q) => $q->where('alta', 1));
    }

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
