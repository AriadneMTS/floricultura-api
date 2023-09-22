<?php

namespace App\Http\Controllers;

use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request) {
        if (Auth::attempt($request->only('email', 'password'))) {
            return Response()->json([
                "message" => "Autorizado",
                "token" => $request->user()->createToken('token')->plainTextToken,
            ]);
        }

        return Response()->json([
            "message" => "Não autorizado"
        ], 403);
    }
}
