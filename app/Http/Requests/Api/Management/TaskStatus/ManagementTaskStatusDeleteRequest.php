<?php

namespace App\Http\Requests\Api\Management\TaskStatus;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read int $taskStatusId
 */
class ManagementTaskStatusDeleteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return User::authorize(Permission::MANAGEMENT_PROJECT_UPDATE);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'taskStatusId' => 'required|integer|exists:task_statuses,id'
        ];
    }
}
