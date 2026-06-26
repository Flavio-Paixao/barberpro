<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuperAdminLoginController extends Controller
{
    public function show()
    {
        if (Auth::check() && Auth::user()->is_superadmin) {
            return redirect()->route('superadmin');
        }
        return view('superadmin.login');
    }

    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if (!$user->is_superadmin) {
                Auth::logout();
                return back()->withErrors(['email' => 'Acesso negado.']);
            }

            $request->session()->regenerate();
            return redirect()->intended(route('superadmin'));
        }

        return back()
            ->withErrors(['email' => 'Credenciais inválidas.'])
            ->withInput($request->only('email'));
    }
}
