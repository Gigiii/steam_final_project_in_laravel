<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreImageRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }
    
    public function prepareForValidation()
    {
        $this->merge([
            'images' => collect($this->input('images'))->map(function ($image) {

                $image['url'] = trim($image['url']);                
                $image['imageable_type'] = trim($image['imageable_type']);                
                $image['imageable_id'] = (int) $image['imageable_id'];
                
                return $image;
            })->all(),
        ]);
    }

    public function rules()
    {
        return [
            'images' => ['required', 'array'],
            'images.*.url' => ['required', 'url', 'max:255'],
            'images.*.imageable_type' => [
                'required',
                'string',
                'in:App\Models\User,App\Models\Game,App\Models\Franchise',
            ],
            'images.*.imageable_id' => [
                'required',
                'integer',
            ],
        ];

    }

    public function messages()
    {
        return [
            'images.required' => 'გთხოვთ, მიუთითოთ სურათების მასივი.',
            'images.array' => 'სურათები უნდა იყოს მასივი.',
            'images.*.url.required' => 'გთხოვთ, მიუთითოთ სურათის URL.',
            'images.*.url.url' => 'გთხოვთ, მიუთითოთ ვალიდური URL მისამართი.',
            'images.*.url.max' => 'URL მისამართი არ უნდა აღემატებოდეს 255 სიმბოლოს.',
            'images.*.imageable_type.required' => 'გთხოვთ, მიუთითოთ მონაცემთა ტიპი.',
            'images.*.imageable_type.string' => 'მონაცემთა ტიპი უნდა იყოს ტექსტი.',
            'images.*.imageable_type.in' => 'მონაცემთა ტიპი არასწორია. დასაშვებია მხოლოდ: User, Game, Franchise.',
            'images.*.imageable_id.required' => 'გთხოვთ, მიუთითოთ მონაცემთა ID.',
            'images.*.imageable_id.integer' => 'მონაცემთა ID უნდა იყოს მთელი რიცხვი.',
            'images.*.imageable_id.exists' => 'მონაცემთა ID არ მოიძებნა შესაბამის ცხრილში.',
        ];
    }
}
