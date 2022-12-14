<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestionHomeResource extends JsonResource
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
            "thumbnail"=>$this->thumbnail,
            "file" => $this->file,
            "file_type"=>$this->file_type,
            "description"=> $this->description,
            "expertes"=>$this->getExpertes($this->id),
            "is_like" => $this->isLike($this->id),
            "is_comment" => $this->isComment($this->id),
            "is_share" => $this->isshare($this->id),
            "user"=> isset($this->user) ? $this->user : null,
            ];
    }
}
