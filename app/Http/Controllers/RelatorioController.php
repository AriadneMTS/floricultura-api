<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Models\Venda;
use DateTime;
use Illuminate\Http\Request;
use PDF;
use Carbon\Carbon;

class RelatorioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * localhost:8000/api/relatorio-vendas?inicio=05-11-2023&fim=06-11-2023
     * @return \Illuminate\Http\Response
     */
    public function relatorioVendas(Request $request)
    {
        $inicio = $request->query("inicio");
        $fim = $request->query("fim");

        $inicioConvertido = date('d/m/Y', strtotime($inicio));
        $fimConvertido = date('d/m/Y', strtotime($fim));

        $inicioPeriodo = Carbon::createFromFormat('d/m/Y', $inicioConvertido)->startOfDay();
        $fimPeriodo = Carbon::createFromFormat('d/m/Y', $fimConvertido)->endOfDay();

        $vendas = Venda::with('produtos', 'cliente:id,nome',)->whereBetween('created_at', [$inicioPeriodo, $fimPeriodo])->get();

        $data = [
            'title' => 'Relatório de Vendas',
            'period' => "$inicioConvertido até $fimConvertido",
            'date' => Carbon::now('America/Sao_Paulo')->format('d/m/Y H:i'),
            'vendas' => $vendas
        ];

        $pdf = PDF::loadView('relatorio-vendas', $data);

        return $pdf->download('relatorio-vendas.pdf');
    }

    public function relatorioProdutosMaisVendidos(Request $request)
    {
        $inicio = $request->query("inicio");
        $fim = $request->query("fim");

        $inicioConvertido = date('d/m/Y', strtotime($inicio));
        $fimConvertido = date('d/m/Y', strtotime($fim));

        $inicioPeriodo = Carbon::createFromFormat('d/m/Y', $inicioConvertido)->startOfDay();
        $fimPeriodo = Carbon::createFromFormat('d/m/Y', $fimConvertido)->endOfDay();

        // ->whereHas('vendas', function($query) use ($inicioPeriodo, $fimPeriodo) {
        //     $query->whereBetween('vendas.created_at', [$inicioPeriodo, $fimPeriodo]);
        // })
        $produtos = Produto::with('vendas')->get();

        $produtoQuantidade = [];

        foreach ($produtos as $produto) {
            $vendas = $produto->vendas()->whereBetween('vendas.created_at', [$inicioPeriodo, $fimPeriodo])->get();
            $quantidade = 0;
            foreach ($vendas as $venda) {
                $quantidade += $venda->pivot->quantidade;
            }

            array_push($produtoQuantidade, [
                "id" => $produto->id,
                "nome" => $produto->nome,
                "quantidade" => $quantidade
            ]);
        }

        usort($produtoQuantidade, function($a, $b) {
            return $b['quantidade'] - $a['quantidade'];
        });

        $data = [
            'title' => 'Relatório de Produtos mais vendidos',
            'period' => "$inicioConvertido até $fimConvertido",
            'date' => Carbon::now('America/Sao_Paulo')->format('d/m/Y H:i'),
            'produtos' => $produtoQuantidade
        ];

        $pdf = PDF::loadView('relatorio-produtos-mais-vendidos', $data);

        return $pdf->download('relatorio-produtos-mais-vendidos.pdf');
    }
}
