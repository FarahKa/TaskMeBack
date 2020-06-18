<?php

namespace App\Http\Controllers;

use App\Ad;
use App\User;
use App\Http\Resources\Ad as AdResource;
use App\Address;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        //get all ads, paginated
        $ads = Ad::paginate(15);
        //return collection of ads as a resource
        return AdResource::collection($ads);
    }



    /**
     * Getting ads of a certain user
     * @param int $id
     * @return AnonymousResourceCollection
     */
    public function ads_by_user($id)
    {
        $user=User::find($id);
        if($user->client)
        {
            $ads=$user->client->ads;
        }
        else{
            $ads=$user->worker->ads;
        }
        return AdResource::collection($ads);
    }
    //ads by country
    /**
     * Getting the ads of a country.
     *
     * @param  string $name
     * @return AnonymousResourceCollection
     */
    public function ads_by_country($name)
    {
        //get tasks that belong to a certain category
        $address = address::where('country',  $name)->first();

        $ads = $address->ads;

        //return collection of tasks as a resource
        return AdResource::collection($ads);
    }

    //post by city
    /**
     * Getting the ads of a city.
     *
     * @param  string $name
     * @return AnonymousResourceCollection
     */
    public function ads_by_city($name)
    {
        //get tasks that belong to a certain category
        $address = address::where('city',  $name)->first();

        $ads = $address->ads;

        //return collection of tasks as a resource
        return AdResource::collection($ads);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return AdResource
     */
    public function store(Request $request)
    {
        // USED NAME ad_id FOR FORM PLZ
        $ad = $request->isMethod('put') ? Ad::findOrFail($request->ad_id) : new Ad;
        $ad->id = $request->input('ad_id');
        $ad->client_id = $request->input('client_id');
        $ad->date=$request->input('date');
        $ad->description = $request->input('description');
        $ad->state = false;
        $address=$request->isMethod('put') ? $ad->address : new Address;
        $address->country= $request->input('country');
        $address->city= $request->input('city');
        $address->postal_code= $request->input('postal_code');
        $address->street= $request->input('street');
        $address->house_number= $request->input('house_number');
        $address->save();
        $ad->address()->associate($address);
        if($ad->save()){
            return new AdResource($ad);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return AdResource
     */
    public function show($id)
    {
        $ad = Ad::findOrFail($id);
        return new AdResource($ad);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return AdResource
     */
    public function destroy($id)
    {
        //find article
        $ad = Ad::findOrFail($id);
        if($ad->delete()){
            return new AdResource($ad);

        }
    }


}
