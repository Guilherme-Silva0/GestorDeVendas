@extends('app.layout.app')

@section('header')

@section('content')
    <div class="flex flex-col items-center  min-h-[calc(100vh-113px)] bg-gray-100">
        <div class="container mx-auto px-4">
            <div class="flex justify-end my-4">
                <button onclick="openModal('addProductModal')"
                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">
                    <i class="fa-solid fa-plus"></i>
                    Adicionar
                    Produto</button>
            </div>
            <div class="bg-white shadow-md rounded">
                <table class="min-w-full bg-white rounded-2xl">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b border-gray-200">ID</th>
                            <th class="py-2 px-4 border-b border-gray-200">Nome</th>
                            <th class="py-2 px-4 border-b border-gray-200">Preço</th>
                            <th class="py-2 px-4 border-b border-gray-200">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <x-products.product-row :product="$product" />
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $products->links() }}
            </div>
        </div>
    </div>

    <x-products.add-product-modal />
    <x-products.edit-product-modal />
@endsection
