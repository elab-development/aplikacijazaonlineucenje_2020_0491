<?php

namespace App\Http\Resources\Location;

use Illuminate\Http\Resources\Json\JsonResource;

class LocationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public static $wrap = 'location';

    public function toArray($request)
    {
        return [
            'name' => $this->resource->name,
            'address' => $this->resource->address . ", " . $this->resource->city,
            'capacity' => $this->resource->capacity
        ];
    }
}
