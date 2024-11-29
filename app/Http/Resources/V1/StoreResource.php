<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StoreResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "type" => $this->type,
            "description" => $this->description,
            "location" => $this->location,
            "imageSource" => $this->image_source,
            "products" => ProductResource::collection($this->whenLoaded("products")),
        ];
    }
}
