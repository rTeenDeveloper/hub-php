<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use App\ActivityModel;

namespace App;

class Activity
{
    private static function getUserActivity($user)
    {
        $activity = array();
        return $activity;
    }

    public static function getActivity($user, $refreshCache)
    {
        return array();
    }
}
