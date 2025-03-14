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
            'title_contains' => 'string|nullable',
            'category' => 'string|nullable',
            'sort' => 'string|in:title,created_at|nullable',
            'order' => 'string|in:asc,desc|nullable',
        ];
    }
}
