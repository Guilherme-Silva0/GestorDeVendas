@extends('app.layout.app')

@section('content')
    <div class="flex flex-col items-center justify-center  min-h-[calc(100vh-113px)] bg-gray-100">
        <div class="container mx-auto p-8">
            <div class="bg-white shadow-md rounded-lg p-6">
                <h2 class="text-2xl font-bold mb-4">Detalhes da Venda</h2>

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">ID da Venda</label>
                    <p class="border border-gray-300 rounded p-2">{{ $sale->id }}</p>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Total da Venda</label>
                    <p class="border border-gray-300 rounded p-2">{{ $sale->total }}</p>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Cliente</label>
                    <p class="border border-gray-300 rounded p-2">{{ $sale->client->name }}</p>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Vendedor</label>
                    <p class="border border-gray-300 rounded p-2">{{ $sale->user->name }}</p>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Produtos Vendidos</label>
                    <ul>
                        @foreach ($sale->products as $product)
                            <li>{{ $product->name }} - Preço: {{ $product->pivot->price }}, Quantidade:
                                {{ $product->pivot->quantity }}</li>
                        @endforeach
                    </ul>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Parcelas</label>
                    <ul>
                        @foreach ($sale->installments as $installment)
                            <li>Número: {{ $installment->number }}, Valor: {{ $installment->value }}, Data de Vencimento:
                                {{ $installment->due_date }}</li>
                        @endforeach
                    </ul>
                </div>

                <div class="flex space-x-4 justify-end">
                    <a href="{{ route('sales.index') }}" id="backButton"
                        class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-700" title="Voltar"><i
                            class="fa-solid fa-arrow-left"></i> Voltar</a>
                    <form action="{{ route('sales.destroy', $sale->id) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button id="deleteButton" type="submit"
                            onclick="return confirm('Tem certeza que deseja excluir esta venda?')" title="Apagar"
                            class="bg-red-500 text-white py-2 px-4 rounded hover:bg-red-700"><i
                                class="fa-solid fa-trash"></i>
                            Apagar</button>
                    </form>
                    <button
                        onclick="openEditSaleModal({sale: {{ json_encode($sale) }}}, '{{ route('sales.update', $sale->id) }}');"
                        id="editButton" title="Editar"
                        class="bg-yellow-500 text-white py-2 px-4 rounded hover:bg-yellow-700"><i class="fas fa-edit"></i>
                        Editar</button>
                </div>
            </div>
        </div>
    </div>
    <x-sales.edit-sale-modal :products="$products" :clients="$clients" />
@endsection
