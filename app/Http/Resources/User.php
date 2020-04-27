<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Client as ClientResource;
use App\Http\Resources\Worker as WorkerResource;
class User extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        if($this->client){
            $child=new ClientResource($this->client);
        }
        else if($this->worker){
            $child=new WorkerResource($this->worker);
        }

        return[
            'firstname'=> $this->firstname,
            'lastname'=> $this->lastname,
            'email'=> $this->email,
            'birth_date'=>$this->birth_date,
            'photo_link'=>$this->photo_link,
            'child'=>$child,
        ];
    }
}
