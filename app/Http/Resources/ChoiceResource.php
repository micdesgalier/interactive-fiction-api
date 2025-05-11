<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ChoiceResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'                => $this->id,
            'chapter_id'        => $this->chapter_id,
            'text'              => $this->text,
            'target_chapter_id' => $this->target_chapter_id,
            'impact'            => $this->impact,
            'created_at'        => $this->created_at,
            'updated_at'        => $this->updated_at,
        ];
    }
}