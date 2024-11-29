<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            "ingredients" => $this->ingredients,
            "type" => $this->type,
            "price" => $this->price,
            "count" => $this->count,
            "imageSource" => $this->image_source,
        ];
    }
}
