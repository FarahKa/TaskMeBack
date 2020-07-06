<?php

namespace App\Http\Controllers;

use App\Ad;
use App\Client;
use App\Http\Resources\Post as PostResource;
use App\Post;
use App\User;
use App\Http\Resources\Ad as AdResource;
use App\Address;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;

class AdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        /*$user = auth()->user();
        if($user->client){
            $ads=Ad::where('client_id', $user->id)->get();
        } elseif ($user->worker){
            $ads=Ad::where('country', $user->country)->get();
        } else {
            $ads = Ad::paginate(5);
        }*/

        $ads = Ad::paginate(5);
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
        //get ads that belong to a certain country
        $addresses = address::where('country',  $name)->get();
        $ads = $addresses->load('ad');

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
        $addresses = address::where('city',  $name)->get();
        $ads = $addresses->load('ad');
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
        $ad->price = $request->input('price');
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return AdResource
     */
    public function editAdState(Request $request){
        $adId = $request->input('id');
        $state = $request->input('state');
        DB::update('update ads set state = ? where id = ?',[$state, $adId]);
        $ad = Ad::find($adId);
        return new AdResource($ad);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return AdResource
     */
    public function editAdWorker(Request $request){
        $adId = $request->input('id');
        $workerId = $request->input('worker_id');
        DB::update('update ads set worker_id = ?, worker_found = ? where id = ?',[$workerId, true, $adId]);
        $ad = Ad::find($adId);
        return new AdResource($ad);
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
