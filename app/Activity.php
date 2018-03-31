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

        // we have to loop through all the integrations
        $integrations = $user->integrations;
        foreach ($integrations as $key => $integration) {
            new Http\Controllers\Integration\GithubController;
            $class = 'App\Http\Controllers\Integration\\' . ucfirst($key).'Controller';
            $object = new $class();

            $ETag = isset($integration['ETag']) ? $integration['ETag'] : '';

            $integrationActivity = $object::getActivity('dante383', $ETag);

            $integrations[$key]['ETag'] = $integrationActivity['ETag'];

            $user->integrations = $integrations;
            $user->save();

            foreach ($integrationActivity['activity'] as $activity)
            {
                $activityModel = new ActivityModel;
                $activityModel->uid = $user->id;
                $activityModel->provider = $key;
                $activityModel->type = isset($activity['type']) ? $activity['type'] : '';
                $activityModel->action = isset($activity['action']) ? $activity['action'] : '';
                $activityModel->created_at = date("Y-m-d h:i:s", strtotime($activity['created_at']));
                $activityModel->data = json_encode($activity['data']);
                $activityModel->save();
            }

            $activity[$key] = $integrationActivity['activity'];
        }
        return $activity;
    }

    public static function getActivity($user, $refreshCache)
    {
        if ($refreshCache == false) {
            if (\Cache::has('user_activity_' . $user->id)) {
                return \Cache::get('user_activity_' . $user->id);
            }
        }

        // we need to get user activity again directly from the providers 

        // first we will get current activity (we want to get all activity, not only the latest)
        $activityHistory = ActivityModel::where('uid', $user->id)->get()->toArray();
    
        $activity = array_merge($activityHistory, Activity::getUserActivity($user));
        \Cache::put('user_activity_' . $user->id, $activity, now()->addMinutes(30));

        return $activity;
    }
}
