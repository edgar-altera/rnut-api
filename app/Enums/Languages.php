<?php

namespace App\Enums;

enum Languages : string
{
    case EN = 'en';
    case ES = 'es';

    public static function all() : array
    {
        $data = [];

        foreach (self::cases() as $case) {
            
            $data[$case->value] = $case->name;
        }

        return $data;
    }
    
    public static function values() : array
    {
        return array_map(fn($case) => $case->value, self::cases());
    }
}
