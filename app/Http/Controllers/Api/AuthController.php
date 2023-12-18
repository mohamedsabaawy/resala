<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request){
        $request->validate([
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:3|confirmed',
            'role'=>'required|in:0,1',
        ]);
        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>$request->password,
            'role'=>$request->role,
        ]);
        if ($user){
            return response()->json($user->createToken("API TOKEN")->plainTextToken,200);
        }
    }

    public function login(Request $request){
        $request->validate([
            'email'=>'required',
            'password'=>'required',
        ]);
        if (!Auth::attempt(['email'=>$request->email,'password'=>$request->password])){
            return response()->json(['please enter valid data'],200);
        }
        $user = Auth::user();
        $token = $user->createToken("API TOKEN")->plainTextToken;
        return response()->json([
            'user'=>$user,
            'token'=>$token
        ],200);
    }
}
