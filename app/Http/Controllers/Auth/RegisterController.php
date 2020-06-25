<?php

namespace App\Http\Controllers\Auth;

use App\Category;
use App\Client;
use App\User;
use App\Http\Controllers\Controller;
use App\Worker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Str;
use App\Http\Resources\User as UserResource;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/api/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            //'password' => ['required', 'string', 'min:1', 'confirmed'],
            'password' => ['required', 'string', 'min:1'],
        ]);
    }


    /**
     * Create a new user instance after a valid registration.
     *
     * @param  Request  $data
     * @return User
     */
    protected function create(Request $data)
    {
        //$data=$request->all();
        $user = new User();
        $user->firstname = $data['firstname'];
        $user->lastname= $data['lastname'];
        $user->email=$data['email'];
        $user->birth_date=$data['birth_date'];
        $user->password=Hash::make($data['password']);
        $user->photo_link=$data['photo_link'];
        $user->gender=$data['gender'];
        $user->country=$data['country'];
        $user->api_token=Str::random(80);
        $user->save();


        /*$user= User::create([
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'email' => $data['email'],
            'birth_date' => $data['birth_date'],
            'password' => Hash::make($data['password']),
            'photo_link' => $data['photo_link'],
            'api_token' => Str::random(80),
        ]);*/
        if($data['type_user']=='worker') {
            $worker = new Worker();
            $worker->user_id=$user->id;
            $worker->cin=$data['cin'];
            $worker->verified= false;
            $worker->phone_number=$data['phone_number'];
            $worker->rating=2.5;
            if($data['skills']){
                foreach($data['skills'] as $skill){
                    $category=Category::firstWhere('name', $skill );
                    $worker->categories()->attach($category->id);
                }
            }

            /*
            $worker = Worker::create([
                'user_id' => $user->id,
                'cin' => $data['cin'],
                'verified' => false,
                'phone_number' => $data['phone_number'],
                'rating'=> 2.5,
            ]);
            */
            //$worker->user()->associate($user);
            $worker->save();
            $user->worker()->associate($worker);

        }

        else if($data['type_user']=='client'){
            $client = new Client();
            $client->user_id=$user->id;
            $client->cin=$data['cin'];
            $client->phone_number=$data['phone_number'];
            $client->rating=2.5;
            /*$client = Client::create([
                'user_id' => $user->id,
                'cin' => $data['cin'],
                'phone_number' => $data['phone_number'],
                'rating'=> 2.5,
            ]);*/
            //$client->user()->associate($client);
            $client->save();
            $user->client()->associate($client);

        }
            return $user;

    }
}
