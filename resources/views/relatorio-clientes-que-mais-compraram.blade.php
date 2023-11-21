<!DOCTYPE html>
<html>
<head>
    <title>Relatório de Clientes que mais compraram</title>
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

    @if(sizeof($clientes) > 0)

        <p>
            <strong>Quantidade de clientes:</strong>
            <span>{{ sizeof($clientes) }}</span>
        </p>
        <table class="table table-bordered">
            <tr>
                <th>Cliente</th>
                <th>Qtd. Compras</th>
                <th>Qtd. Produtos</th>
                <th>Ticket Médio</th>
                <th>Valor Total</th>
            </tr>
            @foreach($clientes as $cliente)
            <tr>
                <td>{{ $cliente["nome"] }}</td>
                <td>{{ $cliente["quantidadeCompras"] }}</td>
                <td>{{ $cliente["quantidadeProdutos"] }}</td>
                @if($cliente["quantidadeCompras"] !== 0)
                <td>{{ formatNumberToBRL($cliente["valorTotal"] / $cliente["quantidadeCompras"]) }}</td>
                @else
                <td>{{ formatNumberToBRL($cliente["valorTotal"]) }}</td>
                @endif
                <td>{{ formatNumberToBRL($cliente["valorTotal"]) }}</td>
            </tr>
            @endforeach
        </table>
    @else
        <p>Não há dados no período selecionado.</p>
    @endif
</body>
</html>
