<!DOCTYPE html>
<html>
<head>
    <title>Relatório de Vendas</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <h1>{{ $title }}</h1>
    <p>
        <strong>Período:</strong>
        <span>{{ $period }}</span>
    </p>
    <p>
        <strong>Relatório gerado em:</strong>
        <span>{{ $date }}</span>
    </p>

    @if(sizeof($vendas) > 0)

        <p>
            <strong>Quantidade de vendas:</strong>
            <span>{{ sizeof($vendas) }}</span>
        </p>
        <table class="table table-bordered">
            <tr>
                <th>Cliente</th>
                <th>V. Total</th>
                <th>Desc.</th>
                <th>M. Pag.</th>
                <th>CPF Colab.</th>
                <th>Data</th>
            </tr>
            @foreach($vendas as $venda)
            <tr>
                <td>{{ $venda->cliente->formattedCpf }}</td>
                <td>{{ $venda->formattedValorTotal }}</td>
                <td>{{ $venda->formattedDesconto }}</td>
                <td>{{ App\Enums\PaymentMethods::fromValue($venda->metodo_pagamento) }}</td>
                <td>{{ $venda->colaborador->formattedCpf }}</td>
                <td>{{ $venda->formattedCreatedAt }}</td>
            </tr>
            @endforeach
        </table>
    @else
        <p>Não há dados no período selecionado.</p>
    @endif
</body>
</html>
