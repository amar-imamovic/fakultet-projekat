<?php

namespace App\Http\Requests\Admin\Role;

use Illuminate\Support\Str;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\ValidationRule;

class StoreRoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Str::lower($this->user()->role?->name) === 'admin';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:50|unique:roles,name',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'You must enter a role name!',
            'name.string' => 'Your role must be text!',
            'name.max' => 'The role name connot be longer than 50 characters!',
            'name.unique' => 'This role already exists!'
        ];
    }
}
