@extends('html')

@section('title', __('Homepage'))

@section('content')

@if (!empty($error))
<div class="message message--error">{{ $error }}</div>
@endif

<form method="POST" action="{{ route('userinfo_form') }}">

    <label class="label" for="username">{{ __('Username') }}</label>
    <input class="input" type="text" id="username" name="username" value="" placeholder="Your IG username" required />

    <input class="button is-primary" type="submit" value="{{ __('Get profile') }}" />

</form>

@endsection
