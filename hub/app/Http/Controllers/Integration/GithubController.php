<?php

namespace App\Http\Controllers\Integration;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Socialite;
use Auth;
use App\User;
use Redirect;

class GithubController extends Controller
{
    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('github')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        $user = Socialite::driver('github')->user();

        $userModel = User::find(Auth::id());

        // changing parameter directly will result in PHP exception
        $integrations = $userModel->integrations;
        $integrations['github'] = array('token' => $user->token, 'username' => $user->getNickname());
        $userModel->integrations = $integrations;
        $userModel->save();

        return Redirect::route('settings.integrations')
        ->with('message', 'Integration was successfully added to your profile!');
    }

    /**
    * Delete integration.
    *
    * @return \Illuminate\Http\Response
    */
    public function removeIntegration()
    {
        $userModel = User::find(Auth::id());

        $integrations = $userModel->integrations;
        unset($integrations['github']);

        $userModel->integrations = $integrations;
        $userModel->save();
    }

    /**
    * Get user activity
    *
    * @return mixed
    */
    public static function getActivity($username, $ETag = '')
    {
        // More about ETag: https://en.wikipedia.org/wiki/HTTP_ETag
        $client = new \GuzzleHttp\Client();
        $res = $client->get('https://api.github.com/users/' . $username . '/events', [
            'headers' => array(
                'If-None-Match' => $ETag
            )]);

        if ($res->getStatusCode() == 304) { // Nothing changed
            return array('ETag' => $res->getHeader('ETag'), 'activity' => array());
        } elseif ($res->getStatusCode() == 200) { // New activity
            $ETag = $res->getHeader('ETag');
            $body = json_decode($res->getBody(), true);

            /*
            Github divides user's activity in blocks, 10 commits in same repository will be in same block, 
            approved PR in other repository will be in other block. We don't want to get all user's activity,
            as it would quickly get tangled with more active users. Instead, we will just get actions type,
            count and repo, and we'll provide link to Github, if anyone would want to see more details.

            TODO: 'intelligent' parser which would search activity entry for 'url', name' and 'body' fields, 
            as they exist in most of the activity types 

            Dear pour soul who's going to edit that code, you may need this:
            https://developer.github.com/v3/activity/events/types/
            */
            $activityArray = array();

            foreach ($body as $activity) {
                $activityParsed = array();

                $activityParsed['type'] = $activity['type'];

                if (isset($activity['action'])) {
                    $activityParsed['action'] = $activity['action'];
                }

                if (isset($activity['repo'])) {
                    $activityParsed['data']['repo'] = array(
                        'name' => $activity['repo']['name']
                    );
                }

                if (isset($activity['created_at']))
                    $activityParsed['created_at'] = $activity['created_at'];

                $activity = $activity['payload'];

                if (isset($activity['url'])) {
                    $activityParsed['url'] = $activity['url'];
                }

                switch ($activityParsed['type']) {
                    case 'CommitCommentEvent':
                        $activityParsed['data']['user'] = array(
                            'avatar' => $activity['comment']['user']['avatar_url']
                        );

                        $activityParsed['data']['body'] = $activity['comment']['body'];
                        break;
                    case 'CreateEvent':
                        $activityParsed['data']['ref_type'] = $activity['ref_type'];
                        $activityParsed['data']['ref'] = $activity['ref'];
                        break;
                    case 'DeleteEvent':
                        $activityParsed['data']['ref_type'] = $activity['ref_type'];
                        $activityParsed['data']['ref'] = $activity['ref'];
                        break;
                    case 'ForkEvent':
                        $activityParsed['data']['forkee'] = array(
                            'name' => $activity['forkee']['name'],
                            'full_name' => $activity['forkee']['full_name']
                        );
                        break;
                    case 'IssueCommentEvent':
                        $activityParsed['data']['issue'] = array(
                            'url' => $activity['issue']['url'],
                            'title' => $activity['issue']['title']
                        );
                        break;
                    case 'IssuesEvent':
                        $activityParsed['data']['issue'] = array(
                            'url' => $activity['issue']['url'],
                            'title' => $activity['issue']['title']
                        );

                        break;
                    case 'MarketplacePurchaseEvent':
                        $activityParsed['data']['marketplace_purchase'] = $activity['marketplace_purchase'];
                        break;
                    case 'MemberEvent':
                        $activityParsed['data']['member'] = array(
                            'username' => $activity['member']['login'],
                            'url' => $activity['member']['html_url']
                         );
                        break;
                    case 'ProjectEvent':
                        $activityParsed['data']['project'] = array(
                            'name' => $activity['project']['name'],
                            'body' => $activity['project']['body']
                        );
                        break;
                    case 'PullRequestEvent':
                        $activityParsed['data']['pull_request'] = array(
                            'url' => $activity['pull_request']['url'],
                            'title' => $activity['pull_request']['title']
                        );
                        break;
                    case 'PullRequestReviewEvent':
                        $activityParsed['data']['pull_request'] = array(
                            'url' => $activity['pull_request']['url'],
                            'title' => $activity['pull_request']['title']
                        );
                        break;
                    case 'PullRequestReviewCommentEvent':
                        $activityParsed['data']['pull_request'] = array(
                            'url' => $activity['pull_request']['url'],
                            'title' => $activity['pull_request']['title']
                        );
                        $activityParsed['data']['comment'] = array(
                            'body' => $activity['comment']['body']
                        );
                        break;
                    case 'PushEvent':
                        $activityParsed['data']['commits_count'] = $activity['distinct_size'];
                        break;
                    case 'ReleaseEvent':
                        $activityParsed['data']['release'] = array(
                            'url' => $activity['release']['url'],
                            'name' => $activity['release']['name'],
                            'tag_name' => $activity['release']['tag_name']
                        );
                        break;
                }
                $activityArray[] = $activityParsed;
            }
            return array(
                'ETag' => $ETag[0],
                'activity' => $activityArray
            );
        }
        return false;
    }
}
