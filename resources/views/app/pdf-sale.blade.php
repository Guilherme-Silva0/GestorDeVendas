<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Detalhes da Venda</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        .table th {
            background-color: #f2f2f2;
            text-align: left;
        }

        .header {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <h1>Detalhes da Venda #{{ $sale->id }}</h1>
    <div class="header">
        <p><strong>Cliente:</strong> {{ $sale->client->name }}</p>
        <p><strong>Vendedor:</strong> {{ $sale->user->name }}</p>
        <p><strong>Total:</strong> R$ {{ number_format($sale->total, 2, ',', '.') }}</p>
    </div>

    <h2>Produtos</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Produto</th>
                <th>Preço</th>
                <th>Quantidade</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sale->products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>R$ {{ number_format($product->pivot->price, 2, ',', '.') }}</td>
                    <td>{{ $product->pivot->quantity }}</td>
                    <td>R$ {{ number_format($product->pivot->price * $product->pivot->quantity, 2, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Parcelas</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Número</th>
                <th>Valor</th>
                <th>Data de Vencimento</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sale->installments as $installment)
                <tr>
                    <td>{{ $installment->number }}</td>
                    <td>R$ {{ number_format($installment->value, 2, ',', '.') }}</td>
                    <td>{{ \Carbon\Carbon::parse($installment->due_date)->format('d/m/Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
