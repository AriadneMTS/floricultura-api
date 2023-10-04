<?php

namespace App\Http\Controllers;

use App\Models\Funcao;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\FuncCall;

class FuncaoController extends Controller
{
    public function index()
    {
        if (!auth()->user()->tokenCan('funcao-index')) {
            return Response()->json([
                "message" => "Sem permissão"
            ], 403);
        }

        $dados = Funcao::get();

        return Response()->json($dados);
    }

    public function store(Request $request)
    {
        if (!auth()->user()->tokenCan('funcao-store')) {
            return Response()->json([
                "message" => "Sem permissão"
            ], 403);
        }

        $dados = $request->except('_token');

        $funcao = Funcao::create($dados);

        return Response()->json($funcao, 201);
    }

    public function show(string $id)
    {
        if (!auth()->user()->tokenCan('funcao-show')) {
            return Response()->json([
                "message" => "Sem permissão"
            ], 403);
        }

        $funcao = Funcao::with('permissoes')->find($id);

        if(!$funcao) {
            return Response()->json([], 404);
        }

        return Response()->json($funcao);
    }

    public function update(Request $request, string $id)
    {
        if (!auth()->user()->tokenCan('funcao-update')) {
            return Response()->json([
                "message" => "Sem permissão"
            ], 403);
        }

        $dados = $request->except('_token');

        $funcao = Funcao::find($id);

        $funcao->update($dados);

        return Response()->json([], 204);
    }

    public function destroy(string $id)
    {
        if (!auth()->user()->tokenCan('funcao-destroy')) {
            return Response()->json([
                "message" => "Sem permissão"
            ], 403);
        }

        Funcao::destroy($id);

        return Response()->json([], 204);
    }
}
