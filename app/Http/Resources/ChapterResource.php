<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ChapterResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'      => $this->id,
            'story_id'=> $this->story_id,
            'title'   => $this->title,
            'content' => $this->content,
            'order'   => $this->order,
            'choices' => ChoiceResource::collection($this->whenLoaded('choices')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}