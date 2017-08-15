<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Calls extends Model
{
    protected $fillable = [
        'call-id', 'from', 'to'
    ];
}
