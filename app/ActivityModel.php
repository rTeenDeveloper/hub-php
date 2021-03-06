<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActivityModel extends Model
{
    protected $table = 'activity';

    public $timestamps = false;

    protected $casts = [
        'data' => 'array'
    ];
}
