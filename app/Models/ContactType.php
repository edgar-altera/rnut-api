<?php

namespace App\Models;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class ContactType extends RnutModel
{
    protected $table = 'tipo_contacto';
    public $timestamps = false;

    public static function cached(): Collection
    {
        return Cache::remember(
            'contact_types:active',
            now()->addDay(),
            fn () => self::all()->keyBy('id')
        );
    }
}
