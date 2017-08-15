<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CallLogs extends Model
{
    protected $fillable = [
        'call-id', 'instruction-id', 'event', 'details'
    ];
}
