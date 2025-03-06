<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class EmailVerificationController extends Controller
{
    public function verifyEmail(Request $request, $id)
    {
        if (!$request->hasValidSignature()) {
            abort(403, 'Enlace inválido o expirado.');
        }

        $user = User::findOrFail($id);

        if (!$user->email_verified_at) {
            $user->email_verified_at = now();
            $user->save();
        }

        return redirect('/')->with('message', 'Correo verificado exitosamente.');
    }
}
