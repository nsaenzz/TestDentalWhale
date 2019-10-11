<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $loginUser = $request->validate([
            'email'     =>  'email|required',
            'password'  => 'required'
        ]);

        if(!auth()->attempt($loginUser)){
            return response(
                [
                    'message'   =>  'Invalid Email or Password',
                    422
                ]
                );
        }

        $userRepository = new UserRepository();
        $accessToken = $userRepository->createUserAccessToken(auth()->user());

        return response(
            [
                'access_token'  => $accessToken,
                'token_type' => 'Bearer'
            ],
            200
        );
    }

    public function logout (Request $request) {

        $token = $request->user()->token();
        $token->revoke();

        return response([
            'message'   =>  'You have been succesfully logged out!'
        ],
        200);
    
    }
}
