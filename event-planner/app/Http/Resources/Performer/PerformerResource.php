<?php

namespace App\Http\Resources\Performer;

use Illuminate\Http\Resources\Json\JsonResource;

class PerformerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public static $wrap = 'performer';

    public function toArray($request)
    {
        return [
            'name' => $this->resource->name,
            'gender' => $this->resource->gender,
            'performance' => $this->resource->performance,
        ];
    }
}
