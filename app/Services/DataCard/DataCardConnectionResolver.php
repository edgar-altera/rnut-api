<?php

namespace App\Services\DataCard;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class DataCardConnectionResolver
{
    public static function get(): string
    {
        return Cache::remember(
            'datacard_active_connection',
            900,
            function () {
                return DB::connection('mysql_dc_ctrl')
                    ->table('dbs')
                    ->where('mode', 'active')
                    ->value('connection');
            }
        );
    }
}
