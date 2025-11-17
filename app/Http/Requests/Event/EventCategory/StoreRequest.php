<?php

namespace App\Http\Requests\Event\EventCategory;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'id' => 'nullable',
            'name' => 'required',
            'color' => ['required', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'color.regex' => 'The color must be a valid color code. e.g. #FF0000',
        ];
    }
}
