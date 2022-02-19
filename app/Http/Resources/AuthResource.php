<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AuthResource extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,

            'username' => $this->username,
            'apiToken' => $this->api_token,

            'firstName' => $this->first_name,
            'lastName'  => $this->last_name,

            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,

            'permissions' => PermissionResource::collection($this->whenLoaded('permissions'))
        ];
    }
}
