<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TwoFactorVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // Verificar si el usuario ha completado 2FA
        if (!$user->two_factor_verified) {
            // Si no ha completado la verificación, redirigir a la página de 2FA
            return redirect()->route('2fa.form')->with('error', 'Completa la verificación 2FA para poder acceder');
        }

        // Si el usuario ha pasado 2FA, continuar con la solicitud
        return $next($request);
    }
}
