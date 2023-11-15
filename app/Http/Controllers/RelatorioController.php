<?php

namespace App\Http\Controllers;

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
}
