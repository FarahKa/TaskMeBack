<?php

namespace App\Http\Controllers\Auth;

use App\Client;
use App\User;
use App\Http\Controllers\Controller;
use App\Worker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Str;

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
    protected $redirectTo = '/home';

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
            'firstName' => ['required', 'string', 'max:255'],
            'lastName' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }


    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {

        $user= User::create([
            'firstName' => $data['firstName'],
            'lastName' => $data['lastName'],
            'email' => $data['email'],
            'birth_date' => $data['birth_date'],
            'password' => Hash::make($data['password']),
            'api_token' => Str::random(80),
        ]);

        $table->bigIncrements('user_id');
        $table->string('cin');
        $table->integer('phone_number');
        $table->boolean('verified');
        $table->decimal(0,5);

        if($data['type_user']=='worker') {
            $worker = Worker::create([
                'user_id' => $user->id,
                'cin' => $data['cin'],
                'verified' => false,
                'phone_number' => $data['phone_number'],
                'rating'=> 0,
            ]);
        }
        else if($data['type_user']=='client'){
            $client = Client::create([
                'user_id' => $user->id,
                'cin' => $data['cin'],
                'phone_number' => $data['phone_number'],
                'rating'=> 0,
            ]);
        }

        return $user;
    }
}
