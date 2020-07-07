<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Ad extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $worker= \App\Worker::find($this->worker_id);
        $address=$this->address;
        //$address= \App\Address::find($this->address_id);
        if($worker){
            $worker_nb = $worker->phone_number;
            $worker_id = $worker->user_id;
            $worker_name = $worker->user->firstname . $worker->user->lastname;
            $worker_rating = $worker->rating;

            return [
                'ad' =>  parent::toArray($request),
                'address'=> $address,
                "worker" => [
                    "worker_number"=>$worker_nb,
                    "worker_id" => $worker_id,
                    "worker_name" => $worker_name,
                    "worker_rating" => $worker_rating,
                ]

            ];
        } else {
            return [
                'ad' =>  parent::toArray($request),
                'address'=> $address,
            ];
        }
    }
}
