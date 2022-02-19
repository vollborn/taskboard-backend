<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskStatusResource extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,

            'name'  => $this->name,
            'color' => $this->color,
            'order' => $this->order,

            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at
        ];
    }
}
