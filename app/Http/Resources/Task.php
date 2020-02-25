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
        //customizing the ressource so we don't add the created at and updatedat to the json
        return[
            'id'=> $this->id,
            'subject'=> $this->subject,
            'description'=> $this->description

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
