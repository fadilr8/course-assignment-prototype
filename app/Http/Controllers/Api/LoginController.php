<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class LoginController extends Controller
{
    public function login(Request $request) {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required', 'min:8']
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Invalid Credentials!'], 401);
        }

        $data = Auth::user();
        $token = $data->createToken('accessToken')->accessToken;
        $status = 'Success';

        return response()->json(compact('data', 'token', 'status'), 200);
    }
}
