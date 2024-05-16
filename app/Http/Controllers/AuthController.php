<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
//            'password' => Hash::make($request['password']),
        ]);

        $token = Auth::login($user);
        return response()->json([
            'status' => '200',
            'message' => 'User Successfully Registered',
            'user' => $user,
            'authorisation' => [
//                'token' => $token,
                'token' => csrf_token(),
                'type' => 'barier',
            ]
        ], 200);

    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $credentials = $request->only(['email', 'password']);
//        $token = auth()->attempt($credentials);
        $token = Auth::attempt($credentials);
        if (!$token) {
            return response()->json(['status' => '401', 'message' => 'Unauthorized'], 401);
//            return response()->json(['error' => 'Unauthorized'], 401);
        }

//        $user = auth()->user();
        $user = Auth::user();
        return response()->json([
            'status' => '200',
//            'token' => $token,
            'message' => 'success login',
            'user' => $user,
            'authorisation' => [
//                'token' => $token,
//                'token' => csrf_token($user),
                'token' => csrf_token(),
                'type' => 'bearer',
            ],
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ], 200);
    }

    public function refresh()
    {
        return response()->json([
            'status' => 'success',
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }
}
