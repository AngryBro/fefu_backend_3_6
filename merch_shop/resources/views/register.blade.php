<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Регистрация</title>
    </head>
    <body>
        <h1>Регистрация</h1>
        <form method="POST" action="{{route('register.post')}}">
            @csrf
            <table>
                <tr>
                    <th>Имя</th>
                    <td><input name='name' value="{{old('name')}}"></input></td>
                </tr>
                <tr>
                    <th>E-mail</th>
                    <td><input name='email' value="{{old('email')}}"></input></td>
                    @error('email')
                        <div class='alert alert-danger'>{{ $message }}</div>
                    @enderror
                </tr>
                <tr>
                    <th>Пароль</th>
                    <td><input name='password' value="{{ old('password') }}"></input></td>
                    @error('password')
                        <div class='alert alert-danger'>{{ $message }}</div>
                    @enderror
                </tr>
                <tr>
                    <td></td>
                    <td><input type='submit'></input></td>
                </tr>
            </table>
        </form>
    </body>
</html>
