<?php

namespace App\Services\Rnut;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class RnutConnectionResolver
{
    public static function get(): string
    {
        return Cache::remember(
            'rnut_active_connection',
            900,
            function () {
                return DB::connection('mysql_rnut_ctrl')
                    ->table('dbs')
                    ->where('mode', 'active')
                    ->value('connection');
            }
        );
    }
}
