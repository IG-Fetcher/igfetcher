@extends('html')

@section('title')
{{ $username }}
@endsection

@section('content')

    Username: {{ $username }}

    <a class="button" href="{{ route('userinfo.json', ['username' => $username]) }}">View as JSON</a>
@endsection
