<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGameRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'title' => 'sometimes|string|max:255',
            'price' => 'sometimes|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lte:price',
            'short_description' => 'sometimes|string|max:500',
            'description' => 'sometimes|string',
            'release_date' => 'sometimes|date',
            'age_rating' => 'sometimes|in:E,E10+,T,M,AO',
        ];
    }

    public function messages(): array
    {
        return [
            'title.string' => 'თამაშის სათაური უნდა იყოს ტექსტური.',
            'title.max' => 'თამაშის სათაური არ უნდა აღემატებოდეს 255 სიმბოლოს.',
            'price.numeric' => 'ფასი უნდა იყოს რიცხვი.',
            'price.min' => 'ფასი არ შეიძლება იყოს უარყოფითი.',
            'sale_price.numeric' => 'ფასდაკლების ფასი უნდა იყოს რიცხვი.',
            'sale_price.min' => 'ფასდაკლების ფასი არ შეიძლება იყოს უარყოფითი.',
            'sale_price.lte' => 'ფასდაკლების ფასი უნდა იყოს ნაკლები ან ტოლი ძირითადი ფასის.',
            'short_description.string' => 'მოკლე აღწერა უნდა იყოს ტექსტური.',
            'short_description.max' => 'მოკლე აღწერა არ უნდა აღემატებოდეს 500 სიმბოლოს.',
            'description.string' => 'აღწერა უნდა იყოს ტექსტური.',
            'release_date.date' => 'გთხოვთ, მიუთითეთ ვალიდური თარიღი.',
            'age_rating.in' => 'ასაკობრივი რეიტინგი უნდა იყოს ერთ-ერთი შემდეგი: E, E10+, T, M, AO.',
        ];
    }
}
