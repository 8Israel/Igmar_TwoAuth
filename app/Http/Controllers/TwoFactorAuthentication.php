<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TwoFactorAuthentication extends Controller
{
    // Mostrar el formulario para ingresar el código 2FA
    public function showVerifyForm()
    {
        return view('auth.verify-2fa');
    }

    // Verificar el código 2FA
    public function verify(Request $request)
    {
        $request->validate([
            '2fa_code' => ['required', 'numeric', 'digits:6'],
        ]);

        $user = Auth::user();

        if ($request->input('2fa_code') == $user->two_factor_code) {
            $user->resetTwoFactorCode();
            $user->two_factor_verified = true;
            $user->save();
            return redirect('/');
        }

        return back()->withErrors(['2fa_code' => 'El código es incorrecto.']);
    }
}
