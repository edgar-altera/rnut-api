<?php

namespace App\Models;

use App\Services\DataCar\DataCarConnectionResolver;
use Illuminate\Database\Eloquent\Model;

abstract class DataCarModel extends Model
{
    public $timestamps = false;
    
    public function getConnectionName()
    {
        return DataCarConnectionResolver::get();
    }

    protected static function booted()
    {
        static::addGlobalScope('active', function ($query) {

            $table = $query->getModel()->getTable();
            
            $query->where("{$table}.alta", 1);
        });
    }
}
