@extends('app.layout.app')

@section('header')

@section('content')
    <div class="flex flex-col items-center  min-h-[calc(100vh-113px)] bg-gray-100">
        <div class="container mx-auto px-4">
            <div class="flex justify-end my-4">
                <button onclick="openModal('addSaleModal')"
                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">
                    <i class="fa-solid fa-plus mr-1"></i>Criar nova venda
                </button>
            </div>
            <div class="bg-white shadow-md rounded">
                <table class="min-w-full bg-white rounded-2xl">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b border-gray-200">ID</th>
                            <th class="py-2 px-4 border-b border-gray-200">Ciente</th>
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
            {{ $sales->links() }}
        </div>
    </div>

    <x-sales.add-sale-modal :products="$products" :clients="$clients" />
    <x-sales.edit-sale-modal :products="$products" :clients="$clients" />
@endsection
