<?php

namespace App\Http\Controllers;

use App\Enums\PaymentMethods;
use App\Models\Produto;
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

        $dados = Venda::with('produtos', 'cliente:id,nome,cpf')->get()->toArray();

        $formatedData = array_map(function($venda) {
            $venda["metodo_pagamento"] = PaymentMethods::fromValue($venda["metodo_pagamento"]);
            return $venda;
        }, $dados);

        return Response()->json($formatedData);
    }

    public function store(Request $request)
    {
        if (!auth()->user()->tokenCan('venda-store')) {
            return Response()->json([
                "message" => "Colaborador sem permissão para cadastrar venda."
            ], 403);
        }

        $dados = $request->except('_token');

        foreach ($dados["produtos"] as $produto) {
            $p = Produto::find($produto["id"]);
            if ($p->estoque < $produto["quantidade"]) {
                return Response()->json([
                    "message" => "Não é possível vender {$produto["quantidade"]} unidade(s) de $p->nome pois existe(m) apenas $p->estoque unidade(s) no estoque."
                ], 403);
            }
        }

        $dados["colaborador_id"] = auth()->user()->id;

        $produtos = array_reduce($dados["produtos"], function ($carry, $produto) {
            $carry[$produto["id"]] = ["quantidade" => $produto["quantidade"]];
            return $carry;
        }, []);

        $venda = Venda::create($dados);

        $venda->produtos()->sync($produtos);

        foreach ($dados["produtos"] as $produto) {
            $p = Produto::find($produto["id"]);
            $p->update(["estoque" => $p->estoque - $produto["quantidade"]]);
        }

        return Response()->json($venda, 201);
    }

    public function show(string $id)
    {
        if (!auth()->user()->tokenCan('venda-show')) {
            return Response()->json([
                "message" => "Colaborador sem permissão para visualizar venda."
            ], 403);
        }

        $venda = Venda::with('produtos', 'cliente')->find($id);

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

        $produtosDaVenda = $venda->produtos()->get();

        $produtosReq = $dados["produtos"];

        // verifica estoque dos produtos que ja estao na venda
        foreach ($produtosDaVenda as $p) {
            $produto_index = array_search($p->id, array_column($produtosReq, "id"));

            if (!$produto_index) {
                continue;
            }

            $produtoReq = $produtosReq[$produto_index];

            $quantidadeEmEstoque = $p->estoque;
            $quantidadeNaVenda = $p->pivot->quantidade;
            $quantidadesSomadas = $quantidadeEmEstoque + $quantidadeNaVenda;

            if ($produtoReq["quantidade"] > $quantidadesSomadas) {
                return Response()->json([
                    "message" => "Não é possível vender {$produtoReq["quantidade"]} unidade(s) de $p->nome pois existe(m) apenas {$quantidadesSomadas} unidade(s) no estoque."
                ], 403);
            }
        }

        // verifica estoque dos novos produtos
        foreach ($dados["produtos"] as $produto) {
            $p = Produto::find($produto["id"]);
            $produto_index = array_search($p->id, array_column($produtosDaVenda->toArray(), "id"));

            if ($produto_index || $produto_index === 0) {
                continue;
            }

            if ($p->estoque < $produto["quantidade"]) {
                return Response()->json([
                    "message" => "Não é possível vender {$produto["quantidade"]} unidade(s) de $p->nome pois existe(m) apenas $p->estoque unidade(s) no estoque."
                ], 403);
            }
        }

        $venda->update($dados);

        $produtos = array_reduce($dados["produtos"], function ($carry, $produto) {
            $carry[$produto["id"]] = ["quantidade" => $produto["quantidade"]];
            return $carry;
        }, []);

        $venda->produtos()->sync($produtos);

        foreach ($produtosDaVenda as $produto) {
            $p = Produto::find($produto->id);
            $p->update(["estoque" => $p->estoque + $produto->pivot->quantidade]);
        }

        foreach ($dados["produtos"] as $produto) {
            $p = Produto::find($produto["id"]);
            $p->update(["estoque" => $p->estoque - $produto["quantidade"]]);
        }

        return Response()->json([], 204);
    }

    public function destroy(string $id)
    {
        if (!auth()->user()->tokenCan('venda-destroy')) {
            return Response()->json([
                "message" => "Colaborador sem permissão para excluir venda."
            ], 403);
        }

        $venda = Venda::find($id);

        $produtosDaVenda = $venda->produtos()->get();

        foreach ($produtosDaVenda as $produto) {
            $p = Produto::find($produto->id);
            $p->update(["estoque" => $p->estoque + $produto->pivot->quantidade]);
        }

        $venda->delete();

        return Response()->json([], 204);
    }
}
