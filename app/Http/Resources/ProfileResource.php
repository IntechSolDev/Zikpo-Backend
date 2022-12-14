<?php

namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $experts = [];
        $topics = [];
        foreach($this->userexpertise as $expert)
        {
            $experts[] = $expert->expertise['title'];
        }
         foreach($this->usertopic as $topic)
        {
            $topics[] = $topic->topic['title'];
        }
        return [
             "id"=> $this->id,
             "name"=> $this->name,
             "image"=> $this->image,
             "username"=> $this->username,
             "image"=> $this->image,
             "email"=> $this->email,
             "mobileno"=> $this->mobileno,
             "expertes"=>$experts,
             "topics"=>$topics,
             "questions"=>$this->userquestions
            ];
    }
}
