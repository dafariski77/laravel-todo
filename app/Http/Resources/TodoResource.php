<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TodoResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "activity" => $this->activity,
            "user_id" => $this->user_id,
            "status" => $this->status,
            "day_id" => $this->day_id,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "user" => $this->whenLoaded('user'),
            "day" => $this->whenLoaded('day')
        ];
    }
}
