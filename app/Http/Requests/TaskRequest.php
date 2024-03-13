<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

use App\Models\Task;

class TaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (!auth()->check()) {
            return false;
        }

        if (($this->isMethod('patch') || $this->isMethod('delete')) && (!$this->id || !Task::find($this->id))) {
            throw new HttpResponseException(response([
                'error' => 'Illegal Access',
            ], 500));
        }

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $taskId = $this->route('id'); // Assuming your route parameter for the task ID is 'task'

        return [
            'title' => 'required|string|max:100|unique:tasks,title,'. $taskId,
            'content' => 'required|string',
            'attachment' => 'nullable',
            'subtask' => 'nullable',
            'status' => 'required|in:0,1,2',
            'is_published' => 'required|boolean',
        ];

    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'error' => $validator->errors()
        ], 422));
    }
}
