<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiClientIp extends Model
{
    public function client()
    {
        return $this->belongsTo(ApiClient::class);
    }
}
