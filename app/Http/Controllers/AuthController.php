<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request){

        // validate fields
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users|email',
            'password' => 'required|string|confirmed'
        ]);

        // Create User
        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password'])
        ]);

        // Create Token
        $token = $user->createToken('householdregtoken')->plainTextToken;

        $response = ([
            'user' => $user,
            'token' => $token
        ]);

        return response($response, 201);
    }

    public function login(Request $request){
        // validate fields
        $fields = $request->validate([
            'email'=>'required|string',
            'password' => 'required|string'
        ]);

        // check email
        $user = User::where('email', $fields['email'])->first();

        // check password
        if(!$user || !Hash::check($fields['password'], $user->password)){
            return response([
                'message'=>'Wrong credentials provided'
            ], 401);
        }

        // Create Token
        $token = $user->createToken('householdregtoken')->plainTextToken;

        $response = [
            'user'=>$user,
            'token'=>$token
        ];

        return response($response, 201);
    }

    // Logout
    public function logout(Request $request){
        auth()->user()->tokens()->delete();

        return response([
            'message'=> 'You are Logged out'
        ]);
    }
}
