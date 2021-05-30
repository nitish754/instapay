<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\SignupRequest;
use App\Http\Services\UserService;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public $service;
    // inject user service class 
    function __construct(UserService $service)
    {
        return $this->service = $service;
    }
    // register user 
    public function Register(SignupRequest $request)
    {
        if ($this->service->checkifUserExist("email", $request->email) == 0) {
            $users =  User::createRecord(["name" => $request->name, "email" => $request->email, "contact" => $request->contact, "password" => $request->password]);
            return response()->json(["message" => "User created successfully"], 200);
        } else {
            return response()->json(["message" => "User is already registered with us"]);
        }
    }

    // Login user 

    public function Login(LoginRequest $request)
    {
        if ($this->service->checkifUserExist("email", $request->email) > 0) {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                // generate auth token for user 
                $response['token'] = auth()->user()->createToken('Laravel Password Grant Client')->accessToken;
                $response['user'] = auth()->user();
                return response()->json($response, 200);
            } else {
                return response()->json(["errors" => "Invalid username or password"], 200);
            }
        } else {
            return response()->json(["message" => "user is not registered with us"], 200);
        }
    }
}
