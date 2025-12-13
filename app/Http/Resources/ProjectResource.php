<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
  public function toArray($request)
  {
    $attributes = $this->toResourceArray();
  
    $attributes['tasks'] = TaskResource::collection($this->whenLoaded('tasks'));

    return $attributes;
  }
}
