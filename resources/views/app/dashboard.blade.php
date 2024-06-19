@extends('app.layout.app')

@section('header')

@section('content')
    <div class="flex flex-col items-center min-h-[calc(100vh-113px)] bg-gray-100">
        <div class="container mx-auto px-4">
            <div class="flex justify-end my-4">
                <button onclick="openModal('addSaleModal')"
                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">
                    <i class="fa-solid fa-plus mr-1"></i>Criar nova venda
                </button>
            </div>
            <x-messages />

            <!-- Formulário de Filtro -->
            <form method="GET" action="{{ route('sales.index') }}" class="mb-4 flex space-x-4">
                <div class="flex-1">
                    <label for="client_filter" class="block text-gray-700">Cliente</label>
                    <select name="client_filter" id="client_filter" class="border border-gray-300 rounded p-2 w-full">
                        <option value="">Selecione um cliente</option>
                        @foreach ($clients as $client)
                            <option value="{{ $client->id }}"
                                {{ request('client_filter') == $client->id ? 'selected' : '' }}>
                                {{ $client->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="flex-1">
                    <label for="user_filter" class="block text-gray-700">Vendedor</label>
                    <select name="user_filter" id="user_filter" class="border border-gray-300 rounded p-2 w-full">
                        <option value="">Selecione um vendedor</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ request('user_filter') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="flex-1">
                    <label for="total_min_filter" class="block text-gray-700">Total Mínimo</label>
                    <input type="number" name="total_min_filter" id="total_min_filter"
                        value="{{ request('total_min_filter') }}" class="border border-gray-300 rounded p-2 w-full">
                </div>
                <div class="flex-1">
                    <label for="total_max_filter" class="block text-gray-700">Total Máximo</label>
                    <input type="number" name="total_max_filter" id="total_max_filter"
                        value="{{ request('total_max_filter') }}" class="border border-gray-300 rounded p-2 w-full">
                </div>
                <div class="flex items-end">
                    <button type="submit"
                        class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-700">Filtrar</button>
                </div>
            </form>

            <div class="bg-white shadow-md rounded">
                <table class="min-w-full bg-white rounded-2xl">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b border-gray-200">ID</th>
                            <th class="py-2 px-4 border-b border-gray-200">Cliente</th>
                            <th class="py-2 px-4 border-b border-gray-200">Vendedor</th>
                            <th class="py-2 px-4 border-b border-gray-200">Preço</th>
                            <th class="py-2 px-4 border-b border-gray-200">Parcelas</th>
                            <th class="py-2 px-4 border-b border-gray-200">Produto</th>
                            <th class="py-2 px-4 border-b border-gray-200">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sales as $sale)
                            <x-sales.sale-row :sale="$sale" />
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $sales->links() }}
            </div>
        </div>
    </div>

    <x-sales.add-sale-modal :products="$products" :clients="$clients" />
    <x-sales.edit-sale-modal :products="$products" :clients="$clients" />
@endsection
