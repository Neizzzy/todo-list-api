<?php

namespace App\Http\Requests;

use App\Enums\TaskStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTaskRequest extends FormRequest
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
        $taskId = $this->route('task') ? $this->route('task')->id : null;

        return [
            'title' => "required|string|max:255|unique:tasks,title,$taskId",
            'description' => 'nullable',
            'status' => ['required', Rule::enum(TaskStatus::class)],
        ];
    }

    public function messages(): array
    {
        $taskStatuses = TaskStatus::valuesAsString();

        return [
            'title.required' => 'Title is required!',
            'title.string' => 'Title must be string!',
            'title.max' => 'Title is too long!',
            'title.unique' => 'Title already exists',
            'description.string' => 'Description should be string!',
            'status.required' => 'Status is required!',
            'status.enum' => "Invalid status! Valid statuses are: $taskStatuses",
        ];
    }
}
