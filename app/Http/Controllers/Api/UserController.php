<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $validatedUser = $request->validate([
            'name'      => 'required|string|max:55',
            'email'     =>  'email|max:255|required|unique:users',
            'password'  => 'required|string|min:6|confirmed',
            'type'      =>  'in:admin,regular'
        ]);

        $validatedUser['password'] = bcrypt($validatedUser['password']);
        
        $userRepository = new UserRepository();
        $user = $userRepository->createRegisterUser($validatedUser);
        $accessToken = $userRepository->createUserAccessToken($user);
        
        return response(
            [
                'user'  => $user, 
                'access_token'  =>  $accessToken,
                'token_type' => 'Bearer'
            ],
            200
        );
    }

    public function getAllUsers(Request $request)
    {
        $userRepository = new UserRepository();
        if($userRepository->verifyAdmin($request->user()->id))
        {
            return response( $userRepository->getAllUser(), 200);
        }

        return response(
            [
                'message' => 'No Authorized to see this information'
            ],401
        );
    }

    public function getUserById(Request $request, $id)
    {
        $userRepository = new UserRepository();
        if($userRepository->verifyAdmin($request->user()->id) || $request->user()->id == $id)
        {
            $user = $userRepository->getUserById($id);
            if($user){
                return response($user, 200);
            }
            return response(['message' => 'No record Found'], 200);
        }

        return response(
            [
                'message' => 'No Authorized to see this information'
            ],401
        );
    }

}
