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
                "message" => "Colaborador sem permissão para listar funções."
            ], 403);
        }

        $dados = Funcao::get();

        return Response()->json($dados);
    }

    public function store(Request $request)
    {
        if (!auth()->user()->tokenCan('funcao-store')) {
            return Response()->json([
                "message" => "Colaborador sem permissão para cadastrar função."
            ], 403);
        }

        $dados = $request->except('_token');

        $funcao = Funcao::create($dados);
        $funcao->permissoes()->sync($dados["permissoes"]);

        return Response()->json($funcao, 201);
    }

    public function show(string $id)
    {
        if (!auth()->user()->tokenCan('funcao-show')) {
            return Response()->json([
                "message" => "Colaborador sem permissão para visualizar função."
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
                "message" => "Colaborador sem permissão para editar função."
            ], 403);
        }

        $dados = $request->except('_token');

        $funcao = Funcao::find($id);

        $funcao->update($dados);
        $funcao->permissoes()->sync($dados["permissoes"]);

        return Response()->json([], 204);
    }

    public function destroy(string $id)
    {
        if (!auth()->user()->tokenCan('funcao-destroy')) {
            return Response()->json([
                "message" => "Colaborador sem permissão para excluir função."
            ], 403);
        }

        $funcao = Funcao::find($id);

        if ($funcao->colaboradores->all()) {
            return Response()->json([
                "message" => "Não foi possível deletar pois existem um ou mais colaboradores cadastrados com essa função."
            ], 409);
        }

        Funcao::destroy($id);

        return Response()->json([], 204);
    }
}
