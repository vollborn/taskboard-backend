<?php

namespace App\Http\Requests\Api\Management\User;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read int|null $page
 * @property-read int|null $perPage
 * @property-read int|null $hasProjectId
 * @property-read int|null $doesntHaveProjectId
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
            'page'                => 'nullable|integer',
            'perPage'             => 'nullable|integer',
            'hasProjectId'        => 'nullable|integer|exists:projects,id',
            'doesntHaveProjectId' => 'nullable|integer|exists:projects,id'
        ];
    }
}
