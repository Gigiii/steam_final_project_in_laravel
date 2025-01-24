<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetImagesRequest extends FormRequest
{
    public function rules()
    {
        return [
            'imageable_type' => [
                'required',
                'string',
                'in:App\Models\User,App\Models\Game,App\Models\Franchise',
            ],
            'imageable_id' => [
                'required',
                'integer',
            ],
        ];
    }

    public function messages()
    {
        return [
            'imageable_type.required' => 'გთხოვთ, მიუთითოთ მონაცემთა ტიპი.',
            'imageable_type.string' => 'მონაცემთა ტიპი უნდა იყოს ტექსტი.',
            'imageable_type.in' => 'მონაცემთა ტიპი არასწორია. დასაშვებია მხოლოდ: User, Game, Franchise.',
            'imageable_id.required' => 'გთხოვთ, მიუთითოთ მონაცემთა ID.',
            'imageable_id.integer' => 'მონაცემთა ID უნდა იყოს მთელი რიცხვი.',
            'imageable_id.exists' => 'მონაცემთა ID არ მოიძებნა შესაბამის ცხრილში.',
        ];
    }
}