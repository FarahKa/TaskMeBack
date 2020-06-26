<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;

class AuthController extends Controller
{
    /**
     * Handle an authentication attempt.
     *
     * @param  Request  $request
     * @return Response
     */
    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request['email'], 'password' => $request['password']])) {
            return auth()->user();
        }
        return response('Couldnt log in', 401)
            ->header('Content-Type', 'text/plain');

    }

    /**
     * Handle an authentication attempt.
     *
     * @return Response
     */
    public function logout(){
        Auth::logout();
        return response('logged out successfully', 200)
            ->header('Content-Type', 'text/plain');
    }
}
