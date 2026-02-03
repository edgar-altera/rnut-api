<?php

namespace App\Models;

use App\Services\DataCard\DataCardConnectionResolver;
use Illuminate\Database\Eloquent\Model;

abstract class DataCardModel extends Model
{
    public $timestamps = false;
    
    public function getConnectionName()
    {
        return DataCardConnectionResolver::get();
    }

    protected static function booted()
    {
        static::addGlobalScope('active', function ($query) {

            $table = $query->getModel()->getTable();
            
            $query->where("{$table}.alta", 1);
        });
    }
}
