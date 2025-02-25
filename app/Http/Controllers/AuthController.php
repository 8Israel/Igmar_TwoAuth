<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Mostrar formulario de registro.
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Manejar registro de usuario.
     */
    public function register(RegisterRequest $request)
    {
        // Crear el usuario
        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password'])
        ]);

        // Enviar email de verificación
        $user->sendEmailVerificationNotification();
        Auth::login($user);
        Auth::user()->generateTwoFactorCode();
        return redirect()->route('login');
    }

    /**
     * Mostrar formulario de login.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Manejar inicio de sesión.
     */
    public function login(LoginRequest $request)
    {
        // Intentar autenticar
        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();
            $user = Auth::user();
            $user ->two_factor_verified = false;
            $user->save();
            // Si el usuario tiene 2FA activado pero no ha verificado, redirigirlo a la verificación
            if (!Auth::user()->two_factor_verified) {
                Auth::user()->generateTwoFactorCode();
                return redirect()->route('2fa.form');
            }
            return redirect()->route('/');
        }

        return back()->withErrors(['email' => 'Las credenciales no son correctas']);
    }

    /**
     * Cerrar sesión y restablecer 2FA.
     */
    public function logout(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            $user->two_factor_verified = false; // Resetear estado de 2FA
            $user->save();
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
