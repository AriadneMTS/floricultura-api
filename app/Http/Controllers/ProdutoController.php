<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    public function index()
    {
        if (!auth()->user()->tokenCan('produto-index')) {
            return Response()->json([
                "message" => "Sem permissão"
            ], 403);
        }

        $dados = Produto::get();

        return Response()->json($dados);
    }

    public function store(Request $request)
    {
        if (!auth()->user()->tokenCan('produto-store')) {
            return Response()->json([
                "message" => "Sem permissão"
            ], 403);
        }

        $dados = $request->except('_token');

        $produto = Produto::create($dados);

        return Response()->json($produto, 201);
    }

    public function show(string $id)
    {
        if (!auth()->user()->tokenCan('produto-show')) {
            return Response()->json([
                "message" => "Sem permissão"
            ], 403);
        }

        $produto = Produto::find($id);

        if(!$produto) {
            return Response()->json([], 404);
        }

        return Response()->json($produto);
    }

    public function update(Request $request, string $id)
    {
        if (!auth()->user()->tokenCan('produto-update')) {
            return Response()->json([
                "message" => "Sem permissão"
            ], 403);
        }

        $dados = $request->except('_token');

        $produto = Produto::find($id);

        $produto->update($dados);

        return Response()->json([], 204);
    }

    public function destroy(string $id)
    {
        if (!auth()->user()->tokenCan('produto-destroy')) {
            return Response()->json([
                "message" => "Sem permissão"
            ], 403);
        }

        Produto::destroy($id);

        return Response()->json([], 204);
    }
}
