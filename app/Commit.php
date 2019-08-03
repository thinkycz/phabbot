<?php

namespace App;

use App\Abstracts\Notifiable;

class Commit extends Notifiable
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
