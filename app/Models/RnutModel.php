<?php

namespace App\Models;

use App\Services\Rnut\RnutConnectionResolver;
use Illuminate\Database\Eloquent\Model;

abstract class RnutModel extends Model
{
    public function getConnectionName()
    {
        return RnutConnectionResolver::get();
    }

    public $timestamps = false;
}
