<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'username' => 'required|string|max:255|regex:/^[a-zA-Z0-9_]+$/|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/[a-z]/', 
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*?&]/', 
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'username.required' => 'გთხოვთ, შეიყვანოთ მომხმარებლის სახელი.',
            'username.string' => 'მომხმარებლის სახელი უნდა იყოს ტექსტური ფორმატი.',
            'username.max' => 'მომხმარებლის სახელი არ უნდა აღემატებოდეს 255 სიმბოლოს.',
            'username.regex' => 'მომხმარებლის სახელი უნდა შეიცავდეს მხოლოდ ასოებს, რიცხვებს ან ხაზს.',
            'username.unique' => 'ეს მომხმარებლის სახელი უკვე რეგისტრირებულია.',

            'email.required' => 'გთხოვთ, შეიყვანოთ ელ.ფოსტა.',
            'email.string' => 'ელ.ფოსტა უნდა იყოს ტექსტური ფორმატი.',
            'email.email' => 'გთხოვთ, შეიყვანოთ ვალიდური ელ.ფოსტა.',
            'email.max' => 'ელ.ფოსტა არ უნდა აღემატებოდეს 255 სიმბოლოს.',
            'email.unique' => 'ეს ელ.ფოსტა უკვე რეგისტრირებულია.',

            'password.required' => 'გთხოვთ, შეიყვანოთ პაროლი.',
            'password.string' => 'პაროლი უნდა იყოს ტექსტური ფორმატი.',
            'password.min' => 'პაროლი უნდა შეიცავდეს მინიმუმ 8 სიმბოლოს.',
            'password.regex' => 'პაროლი უნდა შეიცავდეს მინიმუმ ერთ მცირე ასოს, დიდ ასოს, რიცხვსა და სიმბოლოს.',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'username' => trim($this->username),
            'email' => strtolower(trim($this->email)),
        ]);
    }

    public function attributes(): array
    {
        return [
            'username' => 'მომხმარებლის სახელი',
            'email' => 'ელ.ფოსტა',
            'password' => 'პაროლი',
        ];
    }
}
