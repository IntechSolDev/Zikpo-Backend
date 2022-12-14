<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ResponseResource extends JsonResource
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
            "file"=> $this->file,
            "thumbnail"=>$this->thumbnail,
            "file_type"=> $this->file_type,
            "description"=> $this->description,
            "comments"=> isset($this->comments) ? $this->comments : null,
            "user"=> isset($this->user) ? $this->user : null,
            "likes"=> isset($this->likes) ? $this->likes : null,
             "question"=> isset($this->question) ? $this->question : null,
            ];
    }
}
