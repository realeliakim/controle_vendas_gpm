<?php

namespace App\Http\Resources;

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
            'id'            => $this->id,
            'name'          => $this->name,
            'description'   => $this->description,
            'price_format'  => $this->price_format($this->price),
            'stock'         => $this->stock,
            'available'     => $this->available,
            'section_id'    => $this->section,
            'created_at'    => $this->created_at,
        ];
    }
}
