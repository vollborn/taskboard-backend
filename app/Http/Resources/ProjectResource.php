<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,

            'name'        => $this->name,
            'description' => $this->description,

            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at
        ];
    }
}
