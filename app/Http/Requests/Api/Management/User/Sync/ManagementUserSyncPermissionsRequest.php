<?php

namespace App\Http\Requests\Api\Management\User\Sync;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read int $userId
 * @property-read array $permissionIds
 */
class ManagementUserSyncPermissionsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return User::authorize(Permission::MANAGEMENT_USER_UPDATE);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'userId'          => 'required|integer|exists:users,id',
            'permissionIds'   => 'nullable|array',
            'permissionIds.*' => 'required|integer|exists:permissions,id'
        ];
    }
}
