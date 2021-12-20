<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>{{ config('app.name') }} - @yield('title')</title>
        <link rel="stylesheet" href="/css/app.css" />
    </head>
    <body>

        <header>
            <div class="container">
                <h1 class="title"><a href="/">{{ config('app.name') }}</a></h1>
                <h1 class="subtitle">@yield('title')</h1>
            </div>
        </header>

        <main>
            <div class="container">
                @yield('content')
            </div>
        </main>

        <footer>
            <div class="container">
                {{ config('app.name') }} - Made with love with Lumen / Laravel
            </div>
        </footer>
    </body>
</html>
