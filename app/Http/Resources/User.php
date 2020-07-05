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
            $user_type='client';
            $child=new ClientResource($this->client);
        }
        else if($this->worker){
            $user_type='worker';
            $child=new WorkerResource($this->worker);
        }

        return[
            'user_type'=>$user_type,
            'api_token'=>$this->api_token,
            'firstname'=> $this->firstname,
            'lastname'=> $this->lastname,
            'email'=> $this->email,
            'birth_date'=>$this->birth_date,
            'photo_link'=>$this->photo_link,
            'email_verified_at' => $this->email_verified_at,
            'info'=>$child,

        ];
    }
}
