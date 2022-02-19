<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id'        => $this->id,

            'username'  => $this->username,
            'firstName' => $this->first_name,
            'lastName'  => $this->last_name,

            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,

            'permissions' => PermissionResource::collection($this->whenLoaded('permissions'))
        ];
    }
}
