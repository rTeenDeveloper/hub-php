@extends('layouts.app')

@section('content')
<div class="container">
<h1>{{$user['name']}}</h1>

<span>@</span><span>{{$user['username']}}</span>

<span>joined {{$user['created_at']->diffForHumans()}}</span>
</div>
@endsection