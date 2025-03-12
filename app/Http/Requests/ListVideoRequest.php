<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ListVideoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title_contains' => 'sometimes|string|max:255',
            'category' => 'sometimes|string|max:255',
            '_per_page' => 'sometimes|integer|min:1|max:100',
            '_page' => 'sometimes|integer|min:1',
            'sort' => 'sometimes|in:title,views,likes,created_at',
            'order' => 'sometimes|in:asc,desc'
        ];
    }
}
