<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
class CoinPurchasedResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $amount =  0;
        if($this->coin > 0)
        {
           $amount =  0.1 * $this->coin;
        }
     
        return[
         'id'=>$this->id,
         'coin'=>$this->coin,
         'message'=>"Purhcased ".$this->coin." Coins - ".$amount."$",
         'date'=>$this->created_at->format('d M,Y')
        ];

    }
}
