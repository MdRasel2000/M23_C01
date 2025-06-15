<?php

namespace App\Http\Controllers\API\V1;

use App\Models\User;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function login(Request $request){


        $request->validate([
          'email' => 'required|string',
          'password' => 'required'

        ]);

        $user = User::where('email',$request->email)->first();

        if(!$user || $user->password !== $request->password){

            return response()->json([

                   'message' => 'Unauthorized',
                   'status' => 401

            ],401);
        }

        $token = $user->createToken('api-token')->plainTextToken;

        //set expire token

        $user->tokens()->latest()->first()->update([

            'expires_at' => now()->addMinutes(1)
        ]);

        return response()->json([

             'data' => [
                'token' => $token,
                'user' =>[
                    'id' =>$user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ]
                ],

                'message' => 'Login Successfull',
                'status' => 200
        ]);
    }

     public function logout(Request $request){

                  $request->user()->currentAccessToken()->delete();

                  return response()->json([
                    'message' => 'logout successfull'
                  ]);
     }





}

