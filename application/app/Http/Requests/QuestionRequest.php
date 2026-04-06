<?php

namespace App\Http\Requests;

use App\Rules\FileTypeValidate;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class QuestionRequest extends FormRequest
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
            'question' => "required",
            'explanation' => "nullable|string",
            'correct_answer' => "required|array|min:1",
            'correct_answer.*' => "required|integer|min:0",
            'options' => "array",
            'options.*' => "required",
            'mark' => "required",
        ];

        if (request()->method() == "POST") {
            $rules['image'] = ['nullable', 'max:3072', 'image', new FileTypeValidate(['jpg', 'jpeg', 'png', 'JPG', 'JPEG', 'PNG'])];
        }
        
        if (request()->method() == "PUT") {
      
            $rules['image'] = ['nullable', 'max:3072', 'image', new FileTypeValidate(['jpg', 'jpeg', 'png', 'JPG', 'JPEG', 'PNG'])];
        }
        return $rules;
    }
}
