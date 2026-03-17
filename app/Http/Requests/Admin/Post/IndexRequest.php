<?php

namespace App\Http\Requests\Admin\Post;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class IndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Str::lower($this->user()->role?->name) === 'admin';
    }

    public function rules(): array
    {
        return [
            'status' => ['nullable', 'in:all,pinned,locked'],
            'sort' => ['nullable', 'in:latest,oldest,most_liked,most_commented'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->mergeIfMissing([
            'status' => 'all',
            'sort' => 'latest',
        ]);
    }
}
