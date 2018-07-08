@extends('layouts.app')

@section('content')
<div class="container">
    <div class="entry-add">
        <form method="POST" action="">
            <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
            <textarea id="entry-add" name="body" rows="4" cols="50" placeholder="What are you thinking about?"></textarea>
            <button type="submit" class="btn btn-success">Submit</button>
        </form>
    </div>
    <div class="entries">
    	@foreach ($entries as $entry)
            <b>{{ $entry->user->username }}</b>
            {{ $entry['body'] }}
        @endforeach
    </div>
</div>
@endsection