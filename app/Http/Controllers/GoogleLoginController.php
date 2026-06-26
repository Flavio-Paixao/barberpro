<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleLoginController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        $googleUser = Socialite::driver('google')->user();

        $user = User::where('email', $googleUser->getEmail())->first();

        if (!$user) {
            return redirect('/login')->withErrors(['email' => 'E-mail não cadastrado no sistema. Entre em contato com o suporte.']);
        }

        Auth::login($user);

        return redirect()->intended('/painel');
    }
}
