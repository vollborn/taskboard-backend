<?php

namespace App\Http\Requests\Api\Management\TaskStatus;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read int $projectId
 * @property-read string $name
 * @property-read string $color
 * @property-read int|null $order
 */
class ManagementTaskStatusStoreRequest extends FormRequest
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
            'projectId' => 'required|int|exists:projects,id',
            'name'      => 'required|string',
            'color'     => 'required|string',
            'order'     => 'nullable|int'
        ];
    }
}
