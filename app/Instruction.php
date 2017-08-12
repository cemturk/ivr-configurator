<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Instruction extends Model
{
    protected $fillable = [
        'code', 'type', 'options', 'parentCode', 'isRoot', 'set_id'
    ];
}
