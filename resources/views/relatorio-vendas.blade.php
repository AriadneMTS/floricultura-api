<!DOCTYPE html>
<html>
<head>
    <title>Relatório de Vendas</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <div style="text-align: center;">
        <img src="{{ public_path('images/logo.png') }}" width="231">
    </div>

    <h1 style="text-align: center;">{{ $title }}</h1>
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

        <p>
            <strong>Valor total:</strong>
            <span>{{ $valor_total }}</span>
        </p>

        <p>
            <strong>Ticket médio:</strong>
            <span>{{ $ticket_medio }}</span>
        </p>
        <table class="table table-bordered">
            <tr>
                <th>Cliente</th>
                <th>Total</th>
                <th>Desconto</th>
                <th>Método</th>
                <th>Data</th>
            </tr>
            @foreach($vendas as $venda)
            <tr>
                <td>{{ $venda->cliente->nome }}</td>
                <td>{{ $venda->formattedValorTotal }}</td>
                <td>{{ $venda->formattedDesconto }}</td>
                <td>{{ App\Enums\PaymentMethods::fromValue($venda->metodo_pagamento) }}</td>
                <td>{{ $venda->formattedCreatedAt }}</td>
            </tr>
            @endforeach
        </table>
    @else
        <p>Não há dados no período selecionado.</p>
    @endif
</body>
</html>
