@extends('user.settings.layout')

@section('container')
<a @if (!isset(Auth::user()->integrations['github'])) href="/integration/github" @else onclick="removeIntegration(this)" @endif data-integration="github">
    <div class="btn btn-success">
        GitHub 
        @if (isset(Auth::user()->integrations['github']))
            <span class="badge">{{Auth::user()->integrations['github']['username']}}</span>
        @endif
    </div>
</a>
<script src="/js/settings_integrations.js"></script>
@endsection