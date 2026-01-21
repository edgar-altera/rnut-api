<?php

namespace App\Models;

use App\Services\Rnut\RnutConnectionResolver;
use Illuminate\Database\Eloquent\Model;

abstract class RnutModel extends Model
{
    public $timestamps = false;
    
    public function getConnectionName()
    {
        return RnutConnectionResolver::get();
    }

    protected static function booted()
    {
        static::addGlobalScope('active', function ($query) {

            $table = $query->getModel()->getTable();
            
            $query->where("{$table}.alta", 1);
        });
    }
}
