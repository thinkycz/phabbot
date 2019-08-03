<?php

namespace App;

use App\Abstracts\Notifiable;

class Task extends Notifiable
{
    protected $fillable = [
        'phid',
        'uri',
        'typeName',
        'name',
        'fullName',
        'status',
    ];
}
