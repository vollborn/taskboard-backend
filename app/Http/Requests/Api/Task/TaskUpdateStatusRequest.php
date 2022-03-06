<?php

namespace App\Http\Requests\Api\Task;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read int $taskId
 * @property-read int $taskStatusId
 */
class TaskUpdateStatusRequest extends FormRequest
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
            'taskStatusId' => 'required|int|exists:task_statuses,id'
        ];
    }
}
