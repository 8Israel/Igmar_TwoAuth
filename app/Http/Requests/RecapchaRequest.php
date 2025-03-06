<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RecapchaRequest extends FormRequest
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
            '2fa_code' => ['required', 'numeric', 'digits:6'],
            'g-recaptcha-response' => 'required|captcha'
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
            '2fa_code' => 'Longitud del codigo incorrecto (6 caracteres)',
            'g-recaptcha-response' => 'required|captcha'
        ];
    }
}
