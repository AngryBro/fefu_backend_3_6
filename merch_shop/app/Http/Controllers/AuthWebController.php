<?php

namespace App\Http\Controllers;


use function view;
use function session;
use function redirect;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\BaseLoginFormRequest;
use App\Http\Requests\BaseRegisterFormRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Hash;
use Carbon\Carbon;

class AuthWebController extends Controller
{
    public function loginForm()
    {
        return view('login');
    }

    public function registerForm()
    {
        return view('register');
    }

    public function login(BaseLoginFormRequest $request)
    {
        $data = $request->validated();

        if (Auth::attempt($data, true)){
            $request->session()->regenerate();
            $user = Auth::user();
            $user->app_logged_in_at = Carbon::now();
            $user->save();
            return redirect(route('profile'));
        }

        return back()->withErrors([
            'email' => 'Неверные данные',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function register(BaseRegisterFormRequest $request)
    {
        $data = $request->validated();

        $user = User::query()
        ->where('email', $data['email'])
        ->first();

        if ($user) {
            $user = User::changeFromRequest($user, $data);
        } else {
            $user = User::createFromRequest($data);
        }

        Auth::login($user);
        $request->session()->regenerate();

        return redirect(route('profile'));
    }
}
