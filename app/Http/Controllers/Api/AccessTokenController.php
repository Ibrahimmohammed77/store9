<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;

class AccessTokenController extends Controller
{
    public function store(Request $request){
        $request->validate([
            'email' =>'required|string|max:255',
            'password' =>'required|string|min:6',
            'device_name' =>'string|max:255',
            'abilities'=>'nullable|array'
        ]);
        $user=User::where('email',$request->email)->first();
        if($user && Hash::check($request->password,$user->password)){
            $device_name=$request->post('device_name',$request->userAgent());
            if($request->post('abilities')){
            $token=$user->createToken($device_name,$request->post('abilities'));
            }
             else{
            $token=$user->createToken($device_name);
             }
            return Response::json([
                'code' => 100,
                'token' => $token->plainTextToken,
                'user' => $user
            ],201);
        }
        return Response::json([
            'code' => 0,
            'message' =>'Invalid Credentials',
        ]); //
    }
    public function destroy($token=null){
        $user=Auth::guard('sanctum')->user();
        if(null === $token){
            $user->currentAccessToken()->delete();
            return  Response::json([
                'code' => 0,
                'message' =>'Deeleted  CurrentToken',
            ],200); //
        }
        $personalAccessToken=PersonalAccessToken::findToken($token);
        if( $user->id==$personalAccessToken->tokenable_id && 
        get_class($user)== $personalAccessToken->tokenable_type ){
            $personalAccessToken->delete();
        }
    }
}
