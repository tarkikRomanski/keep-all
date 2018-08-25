<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Client;

class UserController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $valid = validator(
            $request->only('email', 'name', 'password', 'git_username', 'access_token'),
            [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6',
                'git_username' => 'required|string|max:255',
                'access_token' => 'required|string|max:255'
            ]
        );
        if ($valid->fails()) {
            return response()->json($valid->errors()->all(), Response::HTTP_BAD_REQUEST);
        }
        $data = $request->only('name', 'password', 'email', 'git_username', 'access_token');
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'git_username' => $data['git_username'],
            'access_token' => $data['access_token']
        ]);
        $client = Client::where('password_client', 1)->first();
        $request->request->add([
            'grant_type'    => 'password',
            'client_id'     => $client->id,
            'client_secret' => $client->secret,
            'username'      => $data['email'],
            'password'      => $data['password'],
            'scope'         => null,
        ]);
        $token = Request::create(
            'oauth/token',
            'POST'
        );
        return Route::dispatch($token);
    }
}
