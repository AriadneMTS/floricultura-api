<?php

namespace App\Http\Controllers;

use App\Models\Permissao;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;

class PermissaoController extends Controller
{
    public function index()
    {
        if (!auth()->user()->tokenCan('permissao-index')) {
            return Response()->json([
                "message" => "Sem permissão"
            ], 403);
        }

        $dados = Permissao::get();

        return Response()->json($dados);
    }

    public function store(Request $request)
    {
        if (!auth()->user()->tokenCan('permissao-store')) {
            return Response()->json([
                "message" => "Sem permissão"
            ], 403);
        }

        $dados = $request->except('_token');

        $permisao = Permissao::create($dados);

        return Response()->json($permisao, 201);
    }

    public function show(string $id)
    {
        if (!auth()->user()->tokenCan('permissao-show')) {
            return Response()->json([
                "message" => "Sem permissão"
            ], 403);
        }

        $permisao = Permissao::find($id);

        if(!$permisao) {
            return Response()->json([], 404);
        }

        return Response()->json($permisao);
    }

    public function update(Request $request, string $id)
    {
        if (!auth()->user()->tokenCan('permissao-update')) {
            return Response()->json([
                "message" => "Sem permissão"
            ], 403);
        }

        $dados = $request->except('_token');

        $permissao = Permissao::find($id);

        $permissao->updade($dados);

        return Response()->json([], 204);

    }

    public function destroy(string $id)
    {
        if (!auth()->user()->tokenCan('permissao-destroy')) {
            return Response()->json([
                "message" => "Sem permissão"
            ], 403);
        }

        Permissao::destroy($id);

        return Response()->json([], 204);
    }
}
