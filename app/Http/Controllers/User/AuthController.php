<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;


class AuthController extends Controller
{
 public function register(Request $request)
 {
     $request->validate([
         'name' => 'required|string|max:255',
         'email' => 'required|string|email|max:255|unique:users,email',
         'password' => 'required|string|min:8',
     ]);

     $user = User::create([
         'name' => $request->name,
         'email' => $request->email,
         'password' => Hash::make($request->password),
     ]);

     return response()->json(['message' => 'User registered successfully!', 'user' => $user], 201);
 }

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

     $token = $user->createToken('API Token')->plainTextToken;

     return response()->json(['token' => $token], 200);
 }

 public function logout(Request $request)
 {
     $request->user()->currentAccessToken()->delete();

     return response()->json(['message' => 'Logged out successfully.'], 200);
 }
}
