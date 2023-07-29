<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule as ValidationRule;

class ClassroomRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return ([
            'name'    => 'required |string | max:255',
            'section' => 'nullable|string|max:255',
            'subject' => 'nullable|string|max:255',
            'room' => 'nullable|string|max:255',
            'cover_image_path' => [
                'image',
                ValidationRule::dimensions([
                    'min_width' => 150,
                    'min_height' => 150,
                ]),

            ],
        ]);

    }

    public function message():array {
        return [
            'required'=> ":attribute is imortant field",
        ];

    }
}