<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    protected $fillable = [
        'ip_address',
        'user_agent',
        'url',
        'referrer',
        'session_id',
        'device_type',
        'browser',
        'platform',
        'country',
        'city',
        'visited_at',
    ];
}
