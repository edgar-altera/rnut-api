<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiClientIp extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'api_client_id',
        'ip',
        'description',
        'is_active',
    ];

    public function client()
    {
        return $this->belongsTo(ApiClient::class);
    }
}
