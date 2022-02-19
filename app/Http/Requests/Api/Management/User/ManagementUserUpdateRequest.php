<?php

namespace App\Http\Requests\Api\Management\User;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read int $userId
 * @property-read string $username
 * @property-read string $firstName
 * @property-read string $lastName
 * @property-read string|null $password
 */
class ManagementUserUpdateRequest extends FormRequest
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
            'userId'    => 'required|integer|exists:users,id',
            'username'  => 'required|string|unique:users,username,' . $this->userId,
            'firstName' => 'required|string',
            'lastName'  => 'required|string',
            'password'  => 'nullable|string'
        ];
    }
}
