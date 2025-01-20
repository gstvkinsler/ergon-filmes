<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
        $rules = [
            'title' => 'required|string|max:200',
            'description' => 'required|string|max:300',
            'category' => 'required|string|max:30',
            'status' => 'string|max:30',
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'title.required' => 'O titulo é obrigatório.',
            'description.required' => 'Uma descrição é obrigatória.',
            'category' => 'O campo categoria obrigatório'
        ];
    }
}
