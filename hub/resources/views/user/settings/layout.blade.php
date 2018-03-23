@extends('layouts.app')

@section('content')
<div class="container">
    @if(Session::has('message'))
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            {{ Session::get('message') }}
        </div>
    @endif
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
        	<div class="panel panel-default">
        		<div class="panel-heading">Settings</div>

        		<div class="panel-body">
                    <ul class="nav nav-pills nav-stacked">
                        <li role="presentation" {{ Route::current()->getName() == 'settings' ? 'class=active' : '' }}><a href="{{ route('settings') }}">Profile</a></li>
                        <li role="presentation" {{ Route::current()->getName() == 'settings.security' ? 'class=active' : '' }}><a href="{{ route('settings.security') }}">Security</a></li>
                        <li role="presentation" {{ Route::current()->getName() == 'settings.integrations' ? 'class=active' : '' }}><a href="{{ route('settings.integrations') }}">Integrations</a></li>
                    </ul>

        			@yield('container')
        		</div>
        	</div>
        </div>
    </div>
</div>
@endsection