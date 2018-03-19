@extends('layouts.app')

@section('content')
<div class="container">
<h1>{{$user['name']}}</h1><br>

<span>@</span><span>{{$user['username']}}</span><br>

<span>joined {{$user['created_at']->diffForHumans()}}</span><br>

<span>{{$user['bio']}}</span>
</div>
@endsection