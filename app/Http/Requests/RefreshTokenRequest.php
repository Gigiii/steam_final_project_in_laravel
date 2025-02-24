<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RefreshTokenRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'refresh_token' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'refresh_token.required' => 'გთხოვთ, შეიყვანოთ განახლების ტოკენი.',
            'refresh_token.string' => 'განახლების ტოკენი უნდა იყოს ტექსტური ფორმატი.',
        ];
    }

}
