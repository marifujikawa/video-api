<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVideoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string|nullable',
            'url' => 'sometimes|string|url',
            'thumbnail' => 'sometimes|string|url',
            'category' => 'sometimes|string|max:255',
            'views' => 'sometimes|integer|min:0',
            'likes' => 'sometimes|integer|min:0',
        ];
    }
}
