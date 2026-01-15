<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
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
        return [
            'title' => 'required|string|max:255|unique:tasks,title',
            'description' => 'nullable|string',
            'status' => 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Title is required!',
            'title.string' => 'Title must be string!',
            'title.max' => 'Title is too long!',
            'title.unique' => 'Title already exists',
            'description.string' => 'Description should be string!',
            'status.required' => 'Status is required!',
            'status.string' => 'Status should be string!',
            'status.max' => 'Status is too long',
        ];
    }
}
