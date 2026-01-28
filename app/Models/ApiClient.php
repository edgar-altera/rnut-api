<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiClient extends Model
{
     protected $fillable = [
        'name',
        'api_key_id',
        'api_key_hash',
        'api_secret',
        'rate_limit',
        'is_active',
        'last_used_at',
        'revoked_at',
    ];

    protected $hidden = [
        'api_key_hash',
        'api_secret',
    ];

    protected function casts(): array
    {
        return [
            'api_key_hash' => 'hashed',
            'is_active' => 'boolean',
            'last_used_at' => 'datetime',
            'revoked_at' => 'datetime',
        ];
    }

    public function allowedIps()
    {
        return $this->hasMany(ApiClientIp::class);
    }
}


