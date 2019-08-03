<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    protected $fillable = [
        'class',
        'epoch',
        'authorPHID',
        'chronologicalKey',
        'objectPHID',
        'text'
    ];

    protected $dates = [
        'epoch'
    ];
}
