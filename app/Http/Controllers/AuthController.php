<?php

namespace App\Http\Controllers;

use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request) {

        if (Auth::attempt($request->only('email', 'password'))) {
            $permissoes = array_map(function ($permissao) {
                return $permissao->nome;
            }, $request->user()->funcao->permissoes->all());

            return Response()->json([
                "message" => "Autorizado",
                "token" => $request->user()->createToken(
                    'token',
                    $permissoes
                )->plainTextToken,
            ]);
        }

        return Response()->json([
            "message" => "Não autorizado"
        ], 403);
    }
}
