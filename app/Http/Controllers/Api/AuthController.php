<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    //
    public function login(Request $request)
    {
        if(!empty($request->email) && !empty($request->password))
        {
            $credentials = $request->only('email', 'password');
            if (!Auth::attempt($credentials)) {
                return response()->json(["error" => "errorAuthenticate"], 403);
            }
            
            $user = $request->user();
            $token = $request->user()->createToken('admin_token');
            return response()->json(["User" => new UserResource($user),"token" => $token->plainTextToken,"statusCode"=>403]);
        }
        else return response()->json(["error" => "errorAuthenticate"],403);
    }
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        return response()->json(['message' => 'successfully'],200); 
    }
}
