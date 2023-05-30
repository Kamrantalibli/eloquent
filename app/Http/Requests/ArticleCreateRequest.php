<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleCreateRequest extends FormRequest
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
            'title' => ['required', 'max:255'],
            'slug' => ['nullable', 'max:255'],
            'body' => ['required'],
            'category_id' => ['required'],
            // 'image' => ['nullable', 'image', 'mimes:jpeg,png', 'max:2048'],
            'image' => ['image', 'mimetypes:image/jpeg,image/jpg,image/png', 'max:2048']
        ];
    }
}
