<?php

namespace App\Http\Requests\Api\Task;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

/**
 * @property-read int $projectId
 * @property-read string $name
 * @property-read string $description
 * @property-read int $taskStatusId
 */
class TaskStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'projectId'    => 'required|int|exists:projects,id',
            'name'         => 'required|string',
            'description'  => 'nullable|string',
            'taskStatusId' => 'nullable|int|exists:task_statuses,id'
        ];
    }
}