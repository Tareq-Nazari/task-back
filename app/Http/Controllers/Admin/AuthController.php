<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
   
        $user = User::where('email', $request->email)->first();
   
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials.'], 401);
        }

        return response([
            "message" => 'Successful',
            'Authorization' => $user->createToken('admin',['admin'])->plainTextToken,
            'permissions' => $user->permissions()->get()->pluck('id')
        ],200);
    }
    public function register(Request $request){
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'name' => 'required|string|max:50',
        ]);
        $user = User::create([
            'email' => $request->email,
            'name' => $request->name,
            'password' => Hash::make($request->password),
            'registered_at' => now()
        ]);
        return response([
            "message" => 'Successful',
            'Authorization' => $user->createToken('admin',['admin'])->plainTextToken,
        ],200);
    }


    public function getPermissions(){
        return response(Auth::user()->permissions()->get()->pluck('id'),200);
    }

    public function logout(Request $request)
    {
        Auth::user()->tokens()->delete();

        return response()->json([],200);
    }
}
