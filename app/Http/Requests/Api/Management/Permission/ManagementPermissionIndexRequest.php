<?php

namespace App\Http\Requests\Api\Management\Permission;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read int|null $page
 * @property-read int|null $perPage
 * @property-read int|null $hasUserId
 * @property-read int|null $doesntHaveUserId
 */
class ManagementPermissionIndexRequest extends FormRequest
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
            'page'    => 'nullable|integer',
            'perPage' => 'nullable|integer',

            'hasUserId'        => 'nullable|integer|exists:users,id',
            'doesntHaveUserId' => 'nullable|integer|exists:users,id'
        ];
    }
}
