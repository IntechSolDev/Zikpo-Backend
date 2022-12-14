<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CircuitResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
             "id"=> $this->id,
            "program_id"=> $this->program_id,
            "detail"=> $this->detail,
            "circuit_name"=> $this->circuit_name,
             "image"=> $this->image,
            ];
    }
}
