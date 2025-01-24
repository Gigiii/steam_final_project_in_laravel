<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'email' => 'required|string|email|max:255',
            'password' => 'required|string',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'email' => strtolower(trim($this->email)),
        ]);
    }

    public function messages()
    {
        return [
            'email.required' => 'გთხოვთ, შეიყვანოთ ელ.ფოსტა.',
            'email.string' => 'ელ.ფოსტა უნდა იყოს ტექსტური ფორმატი.',
            'email.email' => 'გთხოვთ, შეიყვანოთ ვალიდური ელ.ფოსტა.',
            'email.max' => 'ელ.ფოსტა არ უნდა აღემატებოდეს 255 სიმბოლოს.',
            'password.required' => 'გთხოვთ, შეიყვანოთ პაროლი.',
            'password.string' => 'პაროლი უნდა იყოს ტექსტური ფორმატი.',
        ];
    }

}
