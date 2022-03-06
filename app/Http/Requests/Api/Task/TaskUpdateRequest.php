<?php

namespace App\Http\Requests\Api\Task;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read int $taskId
 * @property-read string $name
 * @property-read string $description
 * @property-read int $taskStatusId
 */
class TaskUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return User::authorize(Permission::TASK_UPDATE);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'taskId'       => 'required|int|exists:tasks,id',
            'name'         => 'required|string',
            'description'  => 'nullable|string',
            'taskStatusId' => 'required|int|exists:task_statuses,id'
        ];
    }
}
