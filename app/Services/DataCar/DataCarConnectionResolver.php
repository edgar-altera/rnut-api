<?php

namespace App\Services\DataCar;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class DataCarConnectionResolver
{
    public static function get(): string
    {
        return Cache::remember(
            'data_car_active_connection',
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
