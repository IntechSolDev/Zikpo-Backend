<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
class CoinStatusResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
         $user = Auth::user();
         $message = "";
        if($this->user1 == $user->id)
        {
           $message = $this->status;
        }
        else
        {
              $message = $this->status2;
        }
     
        return[
         'id'=>$this->id,
         'coin'=>$this->coin,
         'message'=>"$message",
         'date'=>$this->created_at->format('d M,Y')
        ];

    }
}
