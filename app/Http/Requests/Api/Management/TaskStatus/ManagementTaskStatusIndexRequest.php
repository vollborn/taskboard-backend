<?php

namespace App\Http\Requests\Api\Management\TaskStatus;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read int|null $page
 * @property-read int|null $perPage
 * @property-read int $projectId
 */
class ManagementTaskStatusIndexRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return User::authorize(Permission::MANAGEMENT_PROJECT_READ);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'projectId' => 'required|integer|exists:projects,id',
            'page'      => 'nullable|integer',
            'perPage'   => 'nullable|integer',
        ];
    }
}
