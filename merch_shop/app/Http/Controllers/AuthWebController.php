<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\BaseLoginFormRequest;
use App\Http\Requests\BaseRegisterFormRequest;
use App\Models\User;
use Auth;


class AuthWebController extends Controller
{
    function loginForm() {
        return view('login');
    }

    function registerForm() {
        return view('register');
    }

    function register(BaseRegisterFormRequest $request) {
        $data = $request->validated();
        $user = User::createFromRequest($data);
        Auth::login($user);
        $request->session()->regenerate();
        return redirect(route('profile'));
    }

    function login(BaseLoginFormRequest $request) {
        $data = $request->validated();
        if(Auth::attempt($data,true)) {
            $request->session()->regenerate();
            return redirect(route('profile'));
        }

        return back()->withErrors([
            'email' => 'Неверные данные'
        ]);
    }

    function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
