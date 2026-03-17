<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->id === $this->post->user_id
            || Str::lower($this->user()->role?->name) === 'admin'
            || Str::lower($this->user()->role?->name) === 'moderator';
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'min:3', 'max:255'],
            'body' => ['required', 'string', 'min:10'],
        ];
    }
}
