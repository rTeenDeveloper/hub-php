<?php

namespace App\Traits;

use App\Activity;

trait HasActivity
{
    public function getActivity ($refreshCache=false) 
    {
        return Activity::getActivity($this, $refreshCache);
    }
}