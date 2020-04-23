<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Task extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     *
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        //customizing the ressource
        return[
            'id'=> $this->id,
            'subject'=> $this->subject,
            'description'=> $this->description,
            'categories'=>CategoryResource::collection($this-category),
            //'posts'=>PostResource::collection($this->whenLoaded(posts)),
            'created_at' => $this->created_at,
        ];
    }


   //add stuff to the data array i'm returning i guess
    public function with($request){
        return [
            'version'=> 'Sprint1',
            'author'=> 'bro are you seeing this',
            'mybro' => 'it doesnt rlly do anything'
        ];
    }
}
