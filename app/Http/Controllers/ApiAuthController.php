<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ApiAuthController extends Controller
{
    public function register(Request $request)
{
    $validatedData = $request->validate([
        'login' => 'required',
        'password' => 'required|min:6',
    ]);

    $user = User::create([
        'login' => $validatedData['login'],
        'password' => bcrypt($validatedData['password']),
    ]);

    return response()->json(['message' => 'User registered successfully']);
}
public function login(Request $request)
{
    $credentials = $request->only('login', 'password');

    if (auth()->attempt($credentials)) {
        $user = User::where('login',$request->login)->first();
        $token = bin2hex(random_bytes(32));
   
        $user->token = $token;
        $user->save();
        return response()->json(['token' => $token]);
    }

    return response()->json(['error' => 'Unauthorized'], 401);
}
}
