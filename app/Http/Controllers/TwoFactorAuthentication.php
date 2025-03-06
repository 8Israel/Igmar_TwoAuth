<?php

namespace App\Http\Controllers;

use App\Http\Requests\RecapchaRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class TwoFactorAuthentication extends Controller
{
    // Mostrar el formulario para ingresar el código 2FA
    public function showVerifyForm()
    {
        if (!session('pending_user_id')) {
            return redirect()->route('login')->withErrors(['error' => 'Acceso no autorizado.']);
        }
        return view('auth.verify-2fa');
    }

    // Verificar el código 2FA
    public function verify(RecapchaRequest $request)
    {
        $user = User::find(session('pending_user_id'));

        if (!$user || !Hash::check($request->input('2fa_code'), $user->two_factor_code)){
            return back()->withErrors(['2fa_code' => 'El código es incorrecto.']);
        }

        // Limpiar código y guardar estado verificado
        $user->resetTwoFactorCode();
        $user->two_factor_verified = true;
        $user->save();

        // Iniciar sesión solo después de verificar el código
        Auth::login($user);
        session()->forget('pending_user_id'); // Eliminar ID temporal

        return redirect()->route('home');
    }
}
