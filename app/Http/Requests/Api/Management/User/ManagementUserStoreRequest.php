<?php

namespace App\Http\Requests\Api\Management\User;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read string $username
 * @property-read string $firstName
 * @property-read string $lastName
 * @property-read string|null $password
 */
class ManagementUserStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return User::authorize(Permission::MANAGEMENT_USER_CREATE);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'username'  => 'required|string|unique:users,username',
            'firstName' => 'required|string',
            'lastName'  => 'required|string',
            'password'  => 'required|string'
        ];
    }
}
