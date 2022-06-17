<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Профиль</title>
    </head>
    <body>
        <h1>Профиль</h1>
        <div>
            <h3>OAuth info:</h3>
            <h4>GitHub:</h4>
            <label>
                <b>Last login date: </b>{{$user['github_logged_in_at'] ?? 'Never'}}<br/>
                <b>Registration date: </b>{{$user['github_registered_at'] ?? 'Never'}}
            </label>
        </div>
        <div>
            <h4>VK:</h4>
            <label>
                <b>Last login date: </b>{{$user['vkontakte_logged_in_at'] ?? 'Never'}}<br/>
                <b>Registration date: </b>{{$user['vkontakte_registered_at'] ?? 'Never'}}
            </label>
        </div>
        <form method='post' action="{{ route('logout') }}">
            @csrf
            <button type='submit'>Выйти</button>
        </form>
    </body>
</html>
