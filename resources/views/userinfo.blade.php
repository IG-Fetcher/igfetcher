@extends('html')

@section('title')
{{ $info['fullname'] }} ({{ $username }})
@endsection

@section('content')

    <div class="userinfo__profile grid">
        <div class="userinfo__profile__picture">
            <img src="{{ $info['profile_picture'] }}" width="150" height="150" style="display: block;border-radius: 50%;" />
        </div>
        <div class="userinfo__profile__info">
            <h2>{{ $info['fullname'] }}</h2>
            <p class="userinfo__profile__username">&commat;{{ $username }}</p>
        </div>
    </div>

    <div class="userinfo__profile__actions">
        <a role="button" href="https://www.instagram.com/{{ $username }}/">View on Instagram</a>
        <a role="button" target="_blank" href="{{ route('userinfo.json', ['username' => $username]) }}">View as JSON</a>
    </div>

    @foreach ($info['medias'] as $media)
        <article class="userinfo__profile__media">
            <div class="grid">
                <div class="userinfo__profile__media__thumbnail">
                    <img src="{{ $media['thumbnail_cached'] }}" style="display: block" />
                </div>
                <div class="userinfo__profile__media__caption">
                    {{ $media['caption'] }}
                    <footer>
                        <a href="{{ $media['link'] }}">{{ $media['link'] }}</a>
                    </footer>
                </div>
            </div>
        </article>
    @endforeach

    <div class="userinfo__profile__actions">
        <a role="button" href="https://www.instagram.com/{{ $username }}/">View on Instagram</a>
        <a role="button" href="{{ route('userinfo.json', ['username' => $username]) }}">View as JSON</a>
    </div>
@endsection
