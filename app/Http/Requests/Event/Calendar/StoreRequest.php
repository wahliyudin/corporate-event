<?php

namespace App\Http\Requests\Event\Calendar;

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
        return [
            "id" => "nullable",
            "title" => "required|string",
            "start_date" => "required",
            "end_date" => "required",
            "company" => "required",
            "category" => "required",
            "pic" => "required|string",
            "description" => "required|string",
            "location" => "required|string",
        ];
    }
}
