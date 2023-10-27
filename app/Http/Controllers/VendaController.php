<?php

namespace App\Http\Controllers;

use App\Models\Venda;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;

class VendaController extends Controller
{
    public function index()
    {
        if (!auth()->user()->tokenCan('venda-index')) {
            return Response()->json([
                "message" => "Colaborador sem permissão para listar vendas."
            ], 403);
        }

        $dados = Venda::get();

        return Response()->json($dados);
    }

    public function store(Request $request)
    {
        if (!auth()->user()->tokenCan('venda-store')) {
            return Response()->json([
                "message" => "Colaborador sem permissão para cadastrar venda."
            ], 403);
        }

        $dados = $request->except('_token');

        $dados["colaborador_id"] = auth()->user()->id;

        $venda = Venda::create($dados);
        $produtos = array_reduce($dados["produtos"], function ($carry, $produto) {
            $carry[$produto["id"]] = ["quantidade" => $produto["quantidade"]];
            return $carry;
        }, []);

        $venda->produtos()->sync($produtos);

        return Response()->json($venda, 201);
    }

    public function show(string $id)
    {
        if (!auth()->user()->tokenCan('venda-show')) {
            return Response()->json([
                "message" => "Colaborador sem permissão para visualizar venda."
            ], 403);
        }

        $venda = Venda::find($id);

        if(!$venda) {
            return Response()->json([], 404);
        }

        return Response()->json($venda);
    }

    public function update(Request $request, string $id)
    {
        if (!auth()->user()->tokenCan('venda-update')) {
            return Response()->json([
                "message" => "Colaborador sem permissão para editar venda."
            ], 403);
        }

        $dados = $request->except('_token');

        $venda = Venda::find($id);

        $venda->update($dados);

        return Response()->json([], 204);
    }

    public function destroy(string $id)
    {
        if (!auth()->user()->tokenCan('venda-destroy')) {
            return Response()->json([
                "message" => "Colaborador sem permissão para excluir venda."
            ], 403);
        }

        Venda::destroy($id);

        return Response()->json([], 204);
    }
}
