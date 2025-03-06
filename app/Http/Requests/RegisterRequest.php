<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'], // Asegura que el email sea único
            'password' => [
                'required',
                'string',
                'min:8', // Mínimo 8 caracteres
                'confirmed', // Confirmación de la contraseña
                'regex:/[A-Z]/', // Al menos una letra mayúscula
                'regex:/[a-z]/', // Al menos una letra minúscula
                'regex:/[0-9]/', // Al menos un número
                'regex:/[\W_]/', // Al menos un carácter especial
            ],
            'g-recaptcha-response' => 'required|captcha', // Validación del reCAPTCHA
        ];
    }

    /**
     * Mensajes de error personalizados.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'El nombre es obligatorio.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.unique' => 'Este correo electrónico ya está registrado.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'password.regex' => 'La contraseña debe contener al menos una letra mayúscula, una letra minúscula, un número y un carácter especial.',
            'g-recaptcha-response.required' => 'Por favor, completa el reCAPTCHA.',
        ];
    }
}
