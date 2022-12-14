<?php

namespace App\Http\Resources;

use App\Models\User;
use App\Models\Comment;
use App\Http\Resources\ReplyResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
  
            $replied_comment = Comment::with('student')->where('reply_to',$this->id)->get();
            $replied = ReplyResource::collection($replied_comment);
        return [
            'id'=>$this->id,
            'comment'=>$this->comment,
            'student_id'=>$this->student->id,
            'student_name'=>$this->student->first_name .' '.$this->student->last_name ,
            'student_image'=>$this->student->image,
            'replies'=>$replied,
            'created_at'=> $this->created_at->format('d-m-Y'),
            
        ];
    }
}
