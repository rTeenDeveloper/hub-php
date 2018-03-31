@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{$user['name']}}</h1><br>

    <span>@</span><span>{{$user['username']}}</span><br>

    <span>joined {{$user['created_at']->diffForHumans()}}</span><br>

    <span>Followers: {{count($user->followers)}}</span>

    <span>{{$user['bio']}}</span>

    @if (Auth::id() != $user['id'])
    	<div id="follow-btn-container">
    		@if (Auth::user()->isFollowing($user['id']))
    			<div class="btn btn-primary" id="follow-btn" onclick="handleFollowBtn(false);">Unfollow</div>
    		@else 
    			<div class="btn btn-success" id="follow-btn" onclick="handleFollowBtn(true);">Follow</div>
    		@endif
    	</div> 
    @endif

    <h2>Activity</h2>
    <ul>
    @foreach ($user->getActivity() as $activity)
        {{ print_r($activity) }}
    @endforeach
    </ul>
</div>

<script src="/js/user_profile.js"></script>
@endsection