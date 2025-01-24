<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ];
    }

    public function messages()
    {
        return [
            'username.required' => 'გთხოვთ, შეიყვანოთ მომხმარებლის სახელი.',
            'username.string' => 'მომხმარებლის სახელი უნდა იყოს ტექსტური ფორმატი.',
            'username.max' => 'მომხმარებლის სახელი არ უნდა აღემატებოდეს 255 სიმბოლოს.',
            'email.required' => 'გთხოვთ, შეიყვანოთ ელ.ფოსტა.',
            'email.string' => 'ელ.ფოსტა უნდა იყოს ტექსტური ფორმატი.',
            'email.email' => 'გთხოვთ, შეიყვანოთ ვალიდური ელ.ფოსტა.',
            'email.max' => 'ელ.ფოსტა არ უნდა აღემატებოდეს 255 სიმბოლოს.',
            'email.unique' => 'ეს ელ.ფოსტა უკვე რეგისტრირებულია.',
            'password.required' => 'გთხოვთ, შეიყვანოთ პაროლი.',
            'password.string' => 'პაროლი უნდა იყოს ტექსტური ფორმატი.',
            'password.min' => 'პაროლი უნდა შეიცავდეს მინიმუმ 6 სიმბოლოს.',
        ];
    }
}
