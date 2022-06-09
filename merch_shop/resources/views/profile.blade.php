<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Профиль</title>
    </head>
    <body>
        <h1>Профиль</h1>
        <form method='post' action="{{ route('logout') }}">
            @csrf
            <button type='submit'>Выйти</button>
        </form>
    </body>
</html>
