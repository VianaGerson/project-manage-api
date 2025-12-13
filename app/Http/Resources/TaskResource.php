<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
  public function toArray($request)
  {
    $attributes = $this->toResourceArray();

    $attributes['difficulty'] = new DifficultyResource($this->whenLoaded('difficulty'));
  
    return $attributes;
  }
}
