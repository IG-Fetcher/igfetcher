<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>{{ config('app.name') }} - @yield('title')</title>
        <link rel="stylesheet" href="/css/pico.css" />
        <link rel="stylesheet" href="/css/app.css" />
    </head>
    <body>

        <header>
            <div class="container">
                <hgroup>
                    <h1 class="title"><a href="/">{{ config('app.name') }}</a></h1>
                    <p class="subtitle">An easy way to fetch data from IG social network</p>
                </hgroup>
            </div>
        </header>

        <main>
            <div class="container">
                @yield('content')
            </div>
        </main>

        <footer>
            <div class="container">
                <strong>{{ config('app.name') }}</strong>
                <br />
                💓 Made with love by <a href="https://github.com/opi" target="_blank">opi</a> with <a href="https://lumen.laravel.com/" target="_blank">Lumen</a>, <a href="https://picocss.com/" target="_blank">Pico CSS</a> and <a href="https://github.com/pgrimaud/instagram-user-feed/" target="_blank">pgrimaud's instagram-user-feed library</a>.
                <br />
                Please destroy patriarchy ✊
            </div>
        </footer>
    </body>
</html>
