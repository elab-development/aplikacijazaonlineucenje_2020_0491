<?php

namespace App\Http\Resources\Event;

use App\Http\Resources\Location\LocationResource;
use App\Http\Resources\Performer\PerformerResource;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public static $wrap = 'event';

    public function toArray($request)
    {
        return [
            'name' => $this->resource->name,
            'performer' => new PerformerResource($this->resource->performer),
            'location' => new LocationResource($this->resource->location),
            'date' => $this->resource->date,
            'number of tickets' => $this->resource->tickets
        ];
    }
}
