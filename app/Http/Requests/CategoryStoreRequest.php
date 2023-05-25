<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required','max:255'],
            'slug' => ['max:255'],
            'description' => ['max:255'],
            'seo_keywords' => ['max:255'],
            'seo_description' => ['max:255'],
        ];
    }

    public function messages() {
        return [
            'name.required' => 'Category :attribute field is required',
            'name.max' => 'Category :attribute field must be no more than 255 characters',
            'description.max' => 'Category :attribute field must be no more than 255 characters',
            'seo_keywords.max' => 'Category :attribute field must be no more than 255 characters',
            'seo_description.max' => 'Category :attribute field must be no more than 255 characters',
        ];      
    }
}
