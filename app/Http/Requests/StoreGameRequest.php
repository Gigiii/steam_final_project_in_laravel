<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGameRequest extends FormRequest
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
            'franchise_id' => 'required|exists:franchises,id',
            'title' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lte:price',
            'short_description' => 'required|string|max:500',
            'description' => 'required|string',
            'release_date' => 'required|date',
            'age_rating' => 'required|in:E,E10+,T,M,AO',
        ];
    }

    public function messages(): array
    {
        return [
            'franchise_id.required' => 'ფრენჩაიზის აიდი აუცილებელია.',
            'franchise_id.exists' => 'ფრენჩაიზის აიდი ვერ მოიძებნა.',

            'title.required' => 'გთხოვთ, შეიყვანეთ თამაშის სათაური.',
            'title.string' => 'თამაშის სათაური უნდა იყოს ტექსტური.',
            'title.max' => 'თამაშის სათაური არ უნდა აღემატებოდეს 255 სიმბოლოს.',

            'price.required' => 'გთხოვთ, შეიყვანეთ ფასი.',
            'price.numeric' => 'ფასი უნდა იყოს რიცხვი.',
            'price.min' => 'ფასი არ შეიძლება იყოს უარყოფითი.',
            
            'sale_price.numeric' => 'ფასდაკლების ფასი უნდა იყოს რიცხვი.',
            'sale_price.min' => 'ფასდაკლების ფასი არ შეიძლება იყოს უარყოფითი.',
            'sale_price.lte' => 'ფასდაკლების ფასი უნდა იყოს ნაკლები ან ტოლი ძირითადი ფასის.',

            'short_description.required' => 'გთხოვთ, შეიყვანეთ მოკლე აღწერა.',
            'short_description.string' => 'მოკლე აღწერა უნდა იყოს ტექსტური.',
            'short_description.max' => 'მოკლე აღწერა არ უნდა აღემატებოდეს 500 სიმბოლოს.',

            'description.required' => 'გთხოვთ, შეიყვანეთ სრული აღწერა.',
            'description.string' => 'აღწერა უნდა იყოს ტექსტური.',

            'release_date.required' => 'გთხოვთ, მიუთითეთ გამოშვების თარიღი.',
            'release_date.date' => 'გთხოვთ, მიუთითეთ ვალიდური თარიღი.',
            
            'age_rating.required' => 'გთხოვთ, მიუთითეთ ასაკობრივი რეიტინგი.',
            'age_rating.in' => 'ასაკობრივი რეიტინგი უნდა იყოს ერთ-ერთი შემდეგი: E, E10+, T, M, AO.',
        ];
    }

}
