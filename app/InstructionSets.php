<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InstructionSets extends Model
{
    protected $fillable = [
        'name','number','xml'
    ];
}
