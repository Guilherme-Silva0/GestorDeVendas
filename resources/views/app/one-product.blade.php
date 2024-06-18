@extends('app.layout.app')

@section('content')
    <div class="flex flex-col items-center justify-center  min-h-[calc(100vh-113px)] bg-gray-100">
        <div class="container mx-auto p-8">
            <div class="bg-white shadow-md rounded-lg p-6">
                <h2 class="text-2xl font-bold mb-4">Detalhes do Produto</h2>
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2" for="productId">ID do Produto</label>
                    <p id="productId" class="border border-gray-300 rounded p-2">{{ $product->id }}</p>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2" for="productName">Nome do Produto</label>
                    <p id="productName" class="border border-gray-300 rounded p-2">{{ $product->name }}</p>
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 font-bold mb-2" for="productPrice">Preço do Produto</label>
                    <p id="productPrice" class="border border-gray-300 rounded p-2">
                        R$ {{ number_format($product->price, 2, ',', '.') }}</p>
                </div>
                <div class="flex space-x-4 justify-end">
                    <a href="{{ route('products.index') }}" id="backButton"
                        class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-700" title="Voltar"><i
                            class="fa-solid fa-arrow-left"></i> Voltar</a>
                    <form action="{{ route('products.destroy', $product->id) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button id="deleteButton" type="submit"
                            onclick="return confirm('Tem certeza que deseja excluir este produto?')" title="Apagar"
                            class="bg-red-500 text-white py-2 px-4 rounded hover:bg-red-700"><i
                                class="fa-solid fa-trash"></i> Apagar</button>
                    </form>
                    <button
                        onclick="openEditProductModal({id: {{ $product->id }}, name: '{{ $product->name }}', price: '{{ $product->price }}'}, '{{ route('products.update', $product->id) }}')"
                        id="editButton" title="Editar"
                        class="bg-yellow-500 text-white py-2 px-4 rounded hover:bg-yellow-700"><i class="fas fa-edit"></i>
                        Editar</button>
                </div>
            </div>
        </div>
    </div>

    <x-products.edit-product-modal />
@endsection
