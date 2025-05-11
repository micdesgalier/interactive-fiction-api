<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StoryResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'creator' => $this->creator->name,
            'chapters' => ChapterResource::collection($this->whenLoaded('chapters')),
            'created_at' => $this->created_at,
        ];
    }
}