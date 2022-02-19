<?php

namespace App\Http\Requests\Api\Management\Project;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read int $projectId
 * @property-read string $name
 * @property-read string $description
 */
class ManagementProjectUpdateRequest extends FormRequest
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
            'projectId'   => 'required|integer|exists:projects,id',
            'name'        => 'required|string',
            'description' => 'required|string'
        ];
    }
}
