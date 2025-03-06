<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

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
            'password' => Hash::make($request['password'],),
            'email_verified_at' => null,
        ]);

        // Generar la URL firmada con expiración de 60 minutos
        $signedUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id]
        );

        // Enviar el correo de verificación
        Mail::raw("Haz clic en este enlace para verificar tu correo: $signedUrl", function ($message) use ($user) {
            $message->to($user->email)
                ->subject('Verifica tu correo');
        });

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
        // Validar credenciales sin iniciar sesión
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors(['email' => 'Las credenciales no son correctas']);
        }
        if (!$user->hasVerifiedEmail()) {
            return back()->withErrors(['email' => 'Debes verificar tu correo antes de continuar.']);
        }

        $user->generateTwoFactorCode();
        session(['pending_user_id' => $user->id]); // Guardar ID temporalmente
        return redirect()->route('2fa.form');
        
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
