@extends('user.settings.layout')

@section('container')
    <form class="form-horizontal" method="POST" action="{{ route('settings.security') }}">
        {{ csrf_field() }}

        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            <label for="password" class="col-md-4 control-label">Actual password</label>

            <div class="col-md-6">
                <input id="password" type="password" class="form-control" name="password" required autofocus>

                @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('new_password') ? ' has-error' : '' }}">
            <label for="new_password" class="col-md-4 control-label">New password</label>

            <div class="col-md-6">
                <input id="new_password" type="password" class="form-control" name="new_password" required autofocus>

                @if ($errors->has('new_password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('new_password') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('new_password_confirmation') ? ' has-error' : '' }}">
            <label for="new_password_confirmation" class="col-md-4 control-label">New password (confirm)</label>

            <div class="col-md-6">
                <input id="new_password_confirmation" type="password" class="form-control" name="new_password_confirmation" required autofocus>

                @if ($errors->has('new_password_confirmation'))
                    <span class="help-block">
                        <strong>{{ $errors->first('new_password_confirmation') }}</strong>
                    </span>
                @endif
            </div>
        </div>
          
        <div class="form-group">
            <div class="col-md-6 col-md-offset-4">
                <button type="submit" class="btn btn-success">
                    Save
                </button>
            </div>
        </div>

    </form>
@endsection