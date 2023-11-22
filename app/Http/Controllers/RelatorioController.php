<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
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

        $valorTotal = 0;

        foreach ($vendas as $venda) {
            $valorTotal += $venda->valor_total;
        }

        $data = [
            'title' => 'Relatório de Vendas',
            'period' => "$inicioConvertido até $fimConvertido",
            'date' => Carbon::now('America/Sao_Paulo')->format('d/m/Y H:i'),
            'vendas' => $vendas,
            'valor_total' => formatNumberToBRL($valorTotal),
            'ticket_medio' => sizeof($vendas) > 0 ? formatNumberToBRL($valorTotal / sizeof($vendas)) : 0,
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
                "valorUnidade" => $produto->formattedValor,
                "quantidade" => $quantidade,
                "valorTotalEstimado" => $quantidade * $produto->valor,
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

    public function relatorioClientesQueMaisCompraram(Request $request)
    {
        $inicio = $request->query("inicio");
        $fim = $request->query("fim");

        $inicioConvertido = date('d/m/Y', strtotime($inicio));
        $fimConvertido = date('d/m/Y', strtotime($fim));

        $inicioPeriodo = Carbon::createFromFormat('d/m/Y', $inicioConvertido)->startOfDay();
        $fimPeriodo = Carbon::createFromFormat('d/m/Y', $fimConvertido)->endOfDay();

        $clientes = Cliente::get();

        $clienteCompra = [];

        foreach ($clientes as $cliente) {
            $compras = $cliente->compras()->whereBetween('vendas.created_at', [$inicioPeriodo, $fimPeriodo])->get();

            $valorTotal = 0;
            $quantidadeProdutos = 0;
            foreach ($compras as $compra) {
                $valorTotal += $compra->valor_total;
                $produtos = $compra->produtos()->get();
                foreach ($produtos as $produto) {
                    $quantidadeProdutos += $produto->pivot->quantidade;
                }
            }

            array_push($clienteCompra, [
                "id" => $cliente->id,
                "nome" => $cliente->nome,
                "quantidadeCompras" => sizeof($compras),
                "quantidadeProdutos" => $quantidadeProdutos,
                "valorTotal" => $valorTotal,
            ]);
        }

        usort($clienteCompra, function ($a, $b) {
            return $b['valorTotal'] > $a['valorTotal'] ? 1 : -1;
        });

        $data = [
            'title' => 'Relatório de Clientes que mais compraram',
            'period' => "$inicioConvertido até $fimConvertido",
            'date' => Carbon::now('America/Sao_Paulo')->format('d/m/Y H:i'),
            'clientes' => $clienteCompra
        ];

        $pdf = PDF::loadView('relatorio-clientes-que-mais-compraram', $data);

        return $pdf->download('relatorio-clientes-que-mais-compraram.pdf');
    }
}
