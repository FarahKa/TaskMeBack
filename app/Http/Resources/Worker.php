<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Category as CategoryResource;

class Worker extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    public function toArray($request)
    {
        $skills= $this->categories;
        //var_dump($skills);
        return[
            'user_id'=> $this->user_id,
            'cin'=> $this->cin,
            'phone_number'=> $this->phone_number,
            'created_at' => $this->created_at,
            'verified' => $this->verified,
            'rating'=>$this->rating,
            'skills'=>$skills,
        ];
    }
}
