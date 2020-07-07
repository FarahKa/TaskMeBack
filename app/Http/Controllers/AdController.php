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
        $ads= $ads->sortByDesc(function($ad) {
            return $ad->date;
        });
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
        $ads= $ads->sortByDesc(function($ad) {
            return $ad->date;
        });
        return AdResource::collection($ads);
    }

    public function ads_user_current($id)
    {
        $user=User::where('id', $id)->first();

        if($user->client)
        {
            if($user->client->ads) {
                $ads = Ad::where('client_id', "=", $id)->where("state", "=", 0)->get();
            }
            else{
                $ads=[];
            }
        }
        else if ($user->worker) {
            if($user->worker->ads) {
                $ads = Ad::where('worker_id', "=", $id)->where("state", "=", 0)->get();
            } else {
                $ads=[];
            }
        }
        $ads= $ads->sortByDesc(function($ad) {
            return $ad->date;
        });
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
       // $addresses = address::where('country',  $name)->get();
        $ads = Ad::join('addresses', "ads.address_id", '=', 'addresses.id')->where('country', '=', $name)->get();
        $ads= $ads->sortByDesc(function($ad) {
            return $ad->date;
        });
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
        //$ads= Ad::where($this->address->city, "")

        $ads = Ad::whereExists((
            function($query) use ($name){
            $query->select(DB::raw(1))
                ->from('addresses')
                ->whereRaw("addresses.id = ads.address_id")
                ->where("addresses.city", "=", $name );
        }))->where("worker_found", "=", false)->get();
        $ads= $ads->sortByDesc(function($ad) {
            return $ad->date;
        });
        //$Topic= new Ad();
        //$Topic::hydrate((array)$ads);
        //return($ads);
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
        $ad->title = $request->input('title');
        $ad->client_id = $request->input('client_id');
        $ad->date=$request->input('date');
        $ad->description = $request->input('description');
        $ad->state = false;
        $ad->price = $request->input('price');
        $address=$request->isMethod('put') ? $ad->address : new Address;

        $address->id=$ad->id;
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


    public function deleteAdWorker($id){
        DB::update('update ads set worker_id = ?, worker_found = ? where id = ?',[null, false, $id]);
        $ad = Ad::find($id);
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
