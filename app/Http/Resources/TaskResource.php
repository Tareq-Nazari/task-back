<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
        return [
            'id' => $this->id,
            'assigned_to' => $this->assigned_to,
            'owner_id' => $this->owner_id,
            'parent_id' => $this->parent_id,
            'priority' => $this->priority,
            'title' => $this->title,
            'desc' => $this->desc,
            'status' => $this->status,
            'estimated_time' => $this->estimated_time,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
