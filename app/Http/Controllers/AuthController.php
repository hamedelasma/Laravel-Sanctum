<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request){
        $inputs=$request->validate([
            'name'=>'required|string',
            'email'=>'required|string|unique:users,email',
            'password'=>'required|string|confirmed'
        ]);
        $user=User::create([
            'name'=>$inputs['name'],
            'email'=>$inputs['email'],
            'password'=>bcrypt($inputs['password'])
        ]);
        $token=$user->createToken('myapptoken')->plainTextToken;
        $response=[
            'user'=>$user,
            'token'=>$token
        ];
        return response($response, 201);
    }
    public function logout(){
        auth()->user()->tokens()->delete();
        return [
          'message'=>'logout'
        ];
    }
    public function login(Request $request){
        $inputs=$request->validate([
            'email'=>'required|string',
            'password'=>'required|string'
        ]);
        //check the email
        $user = User::where('email',$inputs['email'])->first();
        //check password
        if(!$user|| !Hash::check($inputs['password'],$user->password)){
            return response([
                'message'=>'I Gotcha YOU',
            ], 401);
        }
        $token=$user->createToken('myapptoken')->plainTextToken;
        $response=[
            'user'=>$user,
            'token'=>$token
        ];
        return response($response, 201);
    }
}
