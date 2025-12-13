<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DifficultyResource extends JsonResource
{
  public function toArray($request)
  {
    $attributes = $this->toResourceArray();

    return $attributes;
  }
}
