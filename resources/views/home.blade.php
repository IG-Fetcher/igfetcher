@extends('html')

@section('title', __('Homepage'))

@section('content')

<form method="POST" action="{{ route('userinfo') }}">

    <label class="label" for="username">{{ __('Username') }}</label>
    <input class="input" type="text" id="username" name="username" value="" placeholder="Your IG username" required />

    <input class="button is-primary" type="submit" value="{{ __('Get profile') }}" />

</form>

@endsection
