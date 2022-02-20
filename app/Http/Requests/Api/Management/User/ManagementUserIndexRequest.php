<?php

namespace App\Http\Requests\Api\Management\User;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read int $page
 * @property-read int $perPage
 */
class ManagementUserIndexRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return User::authorize(Permission::MANAGEMENT_USER_READ);
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
            'perPage' => 'nullable|integer'
        ];
    }
}
