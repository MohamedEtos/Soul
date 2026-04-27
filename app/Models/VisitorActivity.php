<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitorActivity extends Model
{
    protected $table = 'visitor_activities';

    protected $fillable = [
        'ip_address',
        'session_id',
        'url',
        'page_title',
        'referrer',
        'duration_seconds',
        'started_at',
        'ended_at',
        'device_type',
        'browser',
        'platform',
        'country',
        'city',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
        'duration_seconds' => 'integer',
    ];
}
